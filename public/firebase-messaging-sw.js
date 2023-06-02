// // Import and configure the Firebase SDK
// // These scripts are made available when the app is served or deployed on Firebase Hosting
// // If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
// importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
// importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

// // Your web app's Firebase configuration
// var firebaseConfig = {
//     apiKey: "AIzaSyB_V08q4UmDxg0folXvu52K2pyWrCu1cRE",
//     authDomain: "gapoktanapp.firebaseapp.com",
//     projectId: "gapoktanapp",
//     storageBucket: "gapoktanapp.appspot.com",
//     messagingSenderId: "314161819154",
//     appId: "1:314161819154:web:02ffebe39462bd7b8232cb",
//     measurementId: "G-D6KMVM4LJ8"
// };
// // Initialize Firebase
// firebase.initializeApp(firebaseConfig);

// // Retrieve an instance of Firebase Messaging so that it can handle background
// // messages.
// const messaging = firebase.messaging();

// messaging.setBackgroundMessageHandler(function(payload) {
//     console.log('[firebase-messaging-sw.js] Received background message ', payload);
//     // Customize notification here
//     const {title, body} = payload.notification;
//     const notificationOptions = {
//         body,
//     };

//     return self.registration.showNotification(title,
//         notificationOptions);
// });
