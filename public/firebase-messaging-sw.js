try {
  // Listener for notification clicks
  self.addEventListener("notificationclick", (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.url)); 
  });

  // Listener for push messages
  self.addEventListener("push", (event) => {
    const payload = event.data ? event.data.json() : {}; // Get the payload from the event
    console.log(payload);
    // Check for notification content in the payload
    if (payload.notification) {
      // Customize the notification
      const options = {
        body: payload.notification.body || "",
        icon: payload.notification.icon || "",
        image: payload.notification.image || null,
        data: payload.data,
        // actions: [{ action: "close", title: "Open in Browser" }],
      };

      // Show the notification
      event.waitUntil(
        self.registration.showNotification(
          payload.notification.title || "Notification",
          options
        )
      );
    } else {
      console.log("No notification data in the payload");
    }
  });
} catch (error) {
  console.error("Error in the service worker:", error);
}
