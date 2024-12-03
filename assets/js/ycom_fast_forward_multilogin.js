fetch('/?rex-api-call=ycom_fast_forward_multi_login&init=1')
.then(response => response.json())
.then(data => {
    const domains = Object.keys(data);


    // Execute the function with the fetched domains
    loginToDomains(domains, token);
})
.catch(error => {
    console.error('Error fetching domains:', error);
});

// Function to log in to each domain
function loginToDomains(domains, token) {
    domains.forEach(domain => {
        const url = `https://${domain}/?rex-api-call=ycom_fast_forward_multi_login&token=${token}`;
        
        fetch(url, {
            method: 'GET',
            credentials: 'include'
        })
        .then(response => {
            if (response.ok) {
                console.log(`Logged in to ${domain} successfully.`);
            } else {
                console.error(`Failed to log in to ${domain}.`);
            }
        })
        .catch(error => {
            console.error(`Error logging in to ${domain}:`, error);
        });
    });
}
