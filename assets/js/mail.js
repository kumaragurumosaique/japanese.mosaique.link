document.getElementById('contact').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    
    xhr.open('POST', 'mail.php', true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('response-message').innerHTML = xhr.responseText;
        } else {
            document.getElementById('response-message').innerHTML = 'An error occurred. Please try again.';
        }
    };
    
    xhr.onerror = function() {
        document.getElementById('response-message').innerHTML = 'An error occurred. Please try again.';
    };

    xhr.send(formData);
});
