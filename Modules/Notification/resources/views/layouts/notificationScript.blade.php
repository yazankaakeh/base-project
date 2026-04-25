<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
      integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha512-OmBbzhZ6lgh87tQFDVBHtwfi6MS9raGmNvUNTjDIBb/cgv707v9OuBVpsN6tVVTLOehRFns+o14Nd0/If0lE/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
<script type="module">

    @if(Auth::user())

    const firebaseConfig = {
        apiKey: "{{config('notification_firebase.fireBase.FB_API_KEY')}}",
        authDomain: "{{config('notification_firebase.fireBase.FB_AUTH_DOMAIN')}}",
        projectId: "{{config('notification_firebase.fireBase.FB_PROJECT_ID')}}",
        storageBucket: "{{config('notification_firebase.fireBase.FB_STORAGE_BUCKET')}}",
        messagingSenderId: "{{config('notification_firebase.fireBase.FB_MESSAGING_SENDER_ID')}}",
        appId: "{{config('notification_firebase.fireBase.FB_APP_ID')}}",
        measurementId: "{{config('notification_firebase.fireBase.FB_MEASUREMENT_ID')}}"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification permission granted.");
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function (token) {
                console.log("token is : " + token);
                fetch('{{route('push_notification')}}', {
                    headers: {"Content-Type": "application/json; charset=utf-8"},
                    method: 'POST',
                    body: JSON.stringify({
                        push_token: token,
                        platform: '{{ PushTokenPlatform::WEB->value }}',
                        _token: document.querySelector("meta[name='csrf-token']").content,
                    })
                })
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });
    }

    messaging.onMessage(function (payload) {
        console.log('new notification')
        console.log(payload)
        iziToast.show({
            color: 'blue', // blue, red, green, yellow
            title: payload.notification.title,
            message: payload.notification.body,
            position: 'bottomLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            timeout: 15000,
        });
    });

    initFirebaseMessagingRegistration();
    console.info("initFirebaseMessagingRegistration done. ");
    @endif

</script>