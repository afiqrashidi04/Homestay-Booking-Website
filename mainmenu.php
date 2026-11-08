<?php
include("header.template.php");
?>

<div style="
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url('img/bgpages.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
">
    <button style="
        padding: 20px 40px;
        font-size: 24px;
        background-color: rgba(0,123,255,0.8);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    " onclick="location.href='RegistrationForm.php'">
        BOOK NOW
    </button>
</div>

<?php
include("footer.template.php");
?>
