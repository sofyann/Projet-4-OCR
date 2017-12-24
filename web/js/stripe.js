var stripe = Stripe('pk_test_XjX2d1w6Sn67Fg0XsqdSFxiq');
var elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
var style = {
    base: {
        // Add your base input styles here. For example:
        fontSize: '16px',
        color: "#32325d"
    }
};

// Create an instance of the card Element
var cardNumber = elements.create('cardNumber', {style: style});
var cardCvc = elements.create('cardCvc', {style: style});
var cardExpiry = elements.create('cardExpiry', {style: style});

// Add an instance of the card Element into the `card-element` <div>
cardNumber.mount('#cardNumber-element', {style : style, hideIcon: false});
cardCvc.mount('#cardCvc-element');
cardExpiry.mount('#cardExpiry-element');

cardNumber.addEventListener('change', errors);
cardCvc.addEventListener('change', errors);
cardExpiry.addEventListener('change', errors);




function errors(event){
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
}
// Create a token or display an error when the form is submitted.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    var options = {
      name: document.getElementById('card-name').value
    };
    console.log(options.name);
    stripe.createToken(cardNumber, options).then(function(result) {
        if (result.error) {
            // Inform the customer that there was an error
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
});
function stripeTokenHandler(token) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}