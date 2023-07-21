

<script src="https://www.paypal.com/sdk/js?client-id=<?= $clientidPaypal['value'] ?>&intent=capture&vault=false&commit=true<?php echo isset($_GET['buyer-country']) ? "&buyer-country=" . $_GET['buyer-country'] : "" ?>&currency=MXN"></script>

<script src="<?= $rootPath ?>assets/js/paypal.js"></script>