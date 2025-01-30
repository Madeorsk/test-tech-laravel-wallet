<html>
<body>
Hi, {{ $wallet->user->name }}!

There is only {{ (new NumberFormatter("fr_FR", NumberFormatter::CURRENCY))->formatCurrency($wallet->balance / 100, "EUR") }} remaining in your wallet.
</body>
</html>
