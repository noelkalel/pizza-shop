# Deployment
```
# Clone repository
git clone https://github.com/noelkalel/pizza-shop.git

# Create environment file for Laravel
cp .env.example .env

# Generate APP_KEY
php artisan key:generate

# Run migration with data for DB
php artisan migrate --seed

# Stripe setup
STRIPE_KEY=your_key
STRIPE_SECRET=your_secret

- Card Number: 4242 4242 4242 4242
- any future day with any cvc code
```
## Login
- username: admin@admin.com
- password: 1111

## P.S.
In order app to fully work you will need to add 3 methods in Cart.php class

public function dollarTotal($decimals = null, $decimalPoint = null, $thousandSeperator = null){
    $content = $this->getContent();

    $total = $content->reduce(function ($total, CartItem $cartItem) {
        $dollar = 114.40;
        $rate = number_format($dollar / 100, 2);

        return $total + ($cartItem->qty * $cartItem->priceTax) * $rate;
    }, 0);

    return $this->numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);    
}

public function dollarTax($decimals = null, $decimalPoint = null, $thousandSeperator = null){
    $content = $this->getContent();

    $dollarTax = $content->reduce(function ($dollarTax, CartItem $cartItem) {
        $dollar = 114.40;
        $rate = number_format($dollar / 100, 2);

        return $dollarTax + ($cartItem->qty * $cartItem->tax) * $rate;
    }, 0);

    return $this->numberFormat($dollarTax, $decimals, $decimalPoint, $thousandSeperator);
}

public function dollarSubtotal($decimals = null, $decimalPoint = null, $thousandSeperator = null){
    $content = $this->getContent();

    $dollarSubtotal = $content->reduce(function ($dollarSubtotal, CartItem $cartItem) {
        $dollar = 114.40;
        $rate = number_format($dollar / 100, 2);

        return $dollarSubtotal + ($cartItem->qty * $cartItem->price) * $rate;
    }, 0);

    return $this->numberFormat($dollarSubtotal, $decimals, $decimalPoint, $thousandSeperator);
}
