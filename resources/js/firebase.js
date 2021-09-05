// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import { onBackgroundMessage } from "firebase/messaging/sw";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyDTXTTIyYwQEHk5MujqEve9C4SkC5Jvn9g",
    authDomain: "test-project-251608.firebaseapp.com",
    databaseURL: "https://test-project-251608.firebaseio.com",
    projectId: "test-project-251608",
    storageBucket: "test-project-251608.appspot.com",
    messagingSenderId: "750098105116",
    appId: "1:750098105116:web:5f6d517aff07b5eeeb30d9"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const messaging = getMessaging();
getToken(messaging, { vapidKey: 'BP-oJHPbKVT8XgAc9EhO0661IauhbzSPndSHcGpa5dA0Gw0kWQX8IY-tLhlnI2pvhz2lQXx0uuPq33GY7GENv0g' }).then((currentToken) => {
    if (currentToken) {
        // Send the token to your server and update the UI if necessary
        console.log(currentToken);

    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        // ...
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
});

onMessage(messaging, (payload) => {
    alert();
    console.log('Message received. ', payload);
    // ...
});
/*
onBackgroundMessage(messaging, (payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
      body: 'Background Message body.',
      icon: '/firebase-logo.png'
    };
  
    self.registration.showNotification(notificationTitle,
      notificationOptions);
  });*/