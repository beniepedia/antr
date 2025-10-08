// Web Push Notification Setup

// Register service worker
if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/sw.js')
        .then(function (registration) {
            console.log('Service Worker registered successfully:', registration);

            // Check if user is subscribed
            return registration.pushManager.getSubscription();
        })
        .then(function (subscription) {
            if (!subscription) {
                // User is not subscribed, ask for permission
                return subscribeUser();
            } else {
                console.log('User is already subscribed:', subscription);
            }
        })
        .catch(function (error) {
            console.error('Service Worker registration failed:', error);
        });
}

async function subscribeUser() {
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') throw new Error('Permission not granted');

    const { publicKey } = await (await fetch('/webpush/vapid-public-key')).json();
    const registration = await navigator.serviceWorker.ready;

    const subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(publicKey)
    });

    const response = await fetch('/webpush/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            endpoint: subscription.endpoint,
            keys: {
                p256dh: arrayBufferToBase64(subscription.getKey('p256dh')),
                auth: arrayBufferToBase64(subscription.getKey('auth'))
            },
            contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0]
        })
    });

    if (!response.ok) throw new Error('Subscription failed');
    console.log('✅ Successfully subscribed');
}

async function unsubscribeUser() {
    try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (!subscription) {
            console.log('⚠️ No active push subscription found.');
            return;
        }

        // Hapus subscription di sisi browser
        await subscription.unsubscribe();

        // Kirim permintaan ke server untuk hapus juga dari DB
        const response = await fetch('/webpush/unsubscribe', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                endpoint: subscription.endpoint
            })
        });

        if (!response.ok) {
            throw new Error('Failed to unsubscribe on server');
        }

        console.log('✅ Successfully unsubscribed from push notifications.');
    } catch (error) {
        console.error('❌ Unsubscribe failed:', error);
    }
}



function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function arrayBufferToBase64(buffer) {
    let binary = '';
    const bytes = new Uint8Array(buffer);
    const len = bytes.byteLength;
    for (let i = 0; i < len; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return window.btoa(binary);
}

// Export for use in other files
window.WebPush = {
    subscribe: subscribeUser,
    unsubscribe: unsubscribeUser
};