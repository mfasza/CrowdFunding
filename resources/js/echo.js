Echo.join('chat-channel')
    .listen('ChatStoredEvent' , (e) => {
        console.log(e);
    });

console.log('Jancok');