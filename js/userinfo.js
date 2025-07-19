
window.onload = function() {
    displayProfile(userData);
};
// After a successful login, dynamically update the profile information
function displayProfile(userData) {

    document.getElementById('profileCircle').style.display = 'block';
    document.getElementById('displayUsername').textContent = userData.username;
    document.getElementById('displayEmail').textContent = userData.email;
    document.getElementById('displayMobile').textContent = userData.mobile;
    document.getElementById('displayGender').textContent = userData.gender;
    document.getElementById('displayAddress').textContent = userData.address;}