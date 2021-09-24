<?php
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
    header("LOCATION:index.php");
    }
?>
<footer>
        <div class="wrapper text-center " style="background:black;color:white;">

            <p>&copy;W.R 2021-17-09</p>
            <p>Ce site à pour but de démontrer mes compétences de développer dans le cadre de mes études
                il n'est donc exposé qu'à titre de démonstration de mes compétences.
            </p>
            <p>Pour toutes informations n'hésitez pas à me contacter à l'adresse suivante</p>
            <a href="mailto:Wetterene.remy@gmail.com"><i class="fas fa-mail-bulk"></i> Contact</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>