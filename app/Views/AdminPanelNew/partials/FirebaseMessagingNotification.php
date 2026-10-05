<!-- Firebase Messaging Notification -->
<?php if (isset($_SESSION['user_id'])): ?>
    <script src="<?= base_url('firebase-app.js') ?>"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/8.2.2/firebase-messaging.js"></script>
    <script type="module">
        const firebaseConfig = <?= $_SESSION['firebase_config'] ?? '{}' ?>;
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const fcm = firebase.messaging();
        fcm.getToken({
                vapidKey: "<?= $_SESSION['firebase_web_push_certificate_key_pair'] ?? "" ?>",
            })
            .then((currentToken) => {
                if (currentToken) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url(route_to('addUserTokenFirebase')) ?>',
                        data: {
                            user_id: '<?= $_SESSION['user_id'] ?>',
                            token: currentToken,
                        },
                        success: function(response) {
                            console.log(response);
                            // Handle success, e.g., show a success message to the user
                        },
                        error: function(error) {
                            console.error(error);
                            // Handle error, e.g., show an error message to the user
                        },
                    });
                } else {
                    console.log(
                        "No registration token available. Request permission to generate one."
                    );
                }
            })
            .catch((err) => {
                console.log("An error occurred while retrieving token. ", err);
            });
        fcm.onMessage((data) => {
            console.log(data);
        });
    </script>
<?php endif; ?>