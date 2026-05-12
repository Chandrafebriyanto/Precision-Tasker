const CACHE_NAME = 'tasker-app-v4';

const PRECACHE_URLS = [
    '/',
    '/tasks',
    '/courses',
    '/archive',
    '/icons/logo-192.png',
    '/icons/logo-512.png',
    '/manifest.json'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_URLS);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.filter((name) => name !== CACHE_NAME)
                .map((name) => caches.delete(name))
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseClone);
                });
                return response;
            })
            .catch(() => {
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) return cachedResponse;
                    
                    if (event.request.mode === 'navigate') {
                        return caches.match('/');
                    }

                    return new Response('', { status: 503, statusText: 'Offline' });
                });
            })
    );
});

self.addEventListener('push', (event) => {
    let data = {};
    
    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = { title: event.data.text() };
        }
    }

    const title = data.title || 'Notifikasi Tasker';
    const options = {
        body: data.body || 'Kamu punya pembaruan tugas baru.',
        icon: '/icons/logo-192.png',
        badge: '/icons/logo-192.png'
    };

    event.waitUntil(self.registration.showNotification(title, options));
});