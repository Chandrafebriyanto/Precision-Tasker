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
    // Hanya proses GET request dan URL valid
    if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Simpan salinan ke cache kalau berhasil ambil dari internet
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseClone);
                });
                return response;
            })
            .catch(() => {
                // JIKA OFFLINE, cari di cache
                return caches.match(event.request).then((cachedResponse) => {
                    // 1. Kalau file (CSS/JS/Image) ada di cache, tampilkan!
                    if (cachedResponse) return cachedResponse;
                    
                    // 2. Kalau halaman utama tidak ada di cache, lempar ke dashboard
                    if (event.request.mode === 'navigate') {
                        return caches.match('/');
                    }

                    // 3. INI KUNCI FIX ERRORNYA: 
                    // Kalau file lain ga ketemu (seperti font), kembalikan response kosong agar tidak crash
                    return new Response('', { status: 503, statusText: 'Offline' });
                });
            })
    );
});

self.addEventListener('push', (event) => {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const data = event.data ? event.data.json() : {};
    const title = data.title || 'Notifikasi Tasker';
    const options = {
        body: data.body || 'Kamu punya pembaruan tugas baru.',
        icon: '/icons/logo-192.png',
        badge: '/icons/logo-192.png'
    };

    event.waitUntil(self.registration.showNotification(title, options));
});