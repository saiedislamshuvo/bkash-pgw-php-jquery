<script>
    $(() => {
        // showLoading();
        payment();
    });

    function payment() {
        showLoading();
        $.ajax({
            url: 'HandleApi.php?action=getToken',
            type: 'POST',
            contentType: 'application/json',
            success: function (data) {
                data = JSON.parse(data);
                if (data.hasOwnProperty('msg')) {
                    data = {
                        errorMessage: data.msg,
                        errorCode: 404,
                        ...data
                    }
                    showErrorMessage(data)
                } else {
                    $('#bKash_button').trigger('click')
                    hideLoading()
                }
            },
            error: function (err) {
                showErrorMessage(err);
            }
        });
    }
    let paymentID = '';
    let paymentRequest = { amount: '1', intent: 'sale' };
    bKash.init({
        paymentMode: 'checkout',
        paymentRequest: paymentRequest,
        createRequest: function (request) {
            createPayment(request);
        },
        executeRequestOnAuthorization: function () {
            executePayment();
        },
        onClose: function () {
            
        }
    });

    function createPayment(request) {
        $.ajax({
            url: 'HandleApi.php?action=createPayment',
            type: 'POST',
            dataType: "text",
            data: request,
            success: function (data) {
                data = JSON.parse(data);
                if (data && data.paymentID != null) {
                    hideLoading()
                    paymentID = data.paymentID;
                    bKash.create().onSuccess(data);
                } else {
                    showErrorMessage(data);
                    bKash.create().onError();
                }
            },
            error: function (err) {
                showErrorMessage(err.responseJSON);
                bKash.create().onError();
            }
        });
    }

    function executePayment() {
        $.ajax({
            url: 'HandleApi.php?action=executePayment',
            type: 'POST',
            dataType: "text",
            data: {
                "paymentID": paymentID
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data) {
                    if (data.paymentID != null) {
                        data = JSON.stringify(data);
                        location.href = 'Success.php?response=' + data
                    } else {
                        showErrorMessage(data);
                        bKash.execute().onError();
                    }
                } else {
                    queryPayment()
                }
            },
            error: function () {
                hideLoading()
                bKash.execute().onError();
            }
        });
    }

    function queryPayment() {
        $.get('HandleApi.php?action=queryPayment', {
            paymentID: paymentID
        }, function (data) {
            data = JSON.parse(data);
            if (data.transactionStatus === 'Completed') {
                data = JSON.stringify(data);
                location.href = 'Success.php?response=' + data
            } else {
                hideLoading()
                let request = {};
                createPayment(request);
            }
        });
    }

    function showErrorMessage(response) {
        hideLoading();
        let message = 'Unknown Error';
        if (response.hasOwnProperty('errorMessage')) {
            let errorCode = parseInt(response.errorCode);
            let bkashErrorCode = [
                2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                2063, 2064, 2065, 2066, 2067, 2068, 2069, 503, 404
            ];
            if (bkashErrorCode.includes(errorCode)) {
                message = response.errorMessage;
            }
        }
        Swal.fire({
            icon: 'error',
            title: 'Payment failed!',
            text: `${message}`,
        });
    }

    function callReconfigure(val) {
        bKash.reconfigure(val);
    }

    function clickPayButton() {
        $("#bKash_button").trigger('click');
    }


    function showLoading() {
        $('#full_page_loading').removeClass('hidden');
    }

    function hideLoading() {
        $('#full_page_loading').addClass('hidden');
    }
</script>