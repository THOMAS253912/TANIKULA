// if('serviceWorker' in navigator){
        //     // Register service worker
        //     navigator.serviceWorkerContainer
        //     .register('js/service-worker.js')
        //     .then(function(reg){
        //     console.log("SW registration succeeded. Scope is "+reg.scope);
        //     }).catch(function(err){
        //         console.error("SW registration failed with error "+err);
        //     });
        // }

console.log('Started', self);
self.addEventListener('install', function(event) {
  self.skipWaiting();
  console.log('Installed', event);
});
self.addEventListener('activate', function(event) {
  console.log('Activated', event);
});
self.addEventListener('push', function(event) {
  console.log('Push message received', event);
});