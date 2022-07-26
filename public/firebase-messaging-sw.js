importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyD8cvkZJ0Ul5x6vj4qSfGVqF1sErG8DYuw",
    authDomain: "dashboard-b7729.firebaseapp.com",
    projectId: "dashboard-b7729",
    storageBucket: "dashboard-b7729.appspot.com",
    messagingSenderId: "300221351761",
    appId: "1:300221351761:web:7323a2cf5c027cb99eb570",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function ({
    data: { title, body, icon },
}) {
    //console.log('[firebase-messaging-sw.js] Received background message ', data);

    // return self.registration.showNotification(title, {
    //     body: body,
    //     icon: icon,
    // });

    // return self.registration.showNotification(title, { body, icon });
});





// self.addEventListener('notificationclick', function (event) {
//     let url = "http://127.0.0.1:8000/admin/orders/display";
//     event.notification.close(); // Android needs explicit close.
//     event.waitUntil(
//         clients.matchAll({ type: 'window' }).then(windowClients => {
//             // Check if there is already a window/tab open with the target URL
//             for (var i = 0; i < windowClients.length; i++) {
//                 var client = windowClients[i];
//                 // If so, just focus it.
//                 if (client.url === url && 'focus' in client) {
//                     return client.focus();
//                 }
//             }
//             // If not, then open the target URL in a new window/tab.
//             if (clients.openWindow) {
//                 return clients.openWindow(url);
//             }
//         })
//     );
// });

// messaging.setBackgroundMessageHandler(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   res = JSON.parse(payload.data.notification)
//   var notificationTitle = res.title;
//   var notificationOptions = {

//     body: res.body,
//     icon: res.icon,
//     image: res.image
//   };

//   self.addEventListener('notificationclick', function(event) {
//     event.notification.close();
//     event.waitUntil(self.clients.openWindow("https://google.com"));
//   });

//   return self.registration.showNotification(notificationTitle,
//     notificationOptions);
// });
