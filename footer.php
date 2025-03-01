<footer class="footer mt-auto py-3 bg-body-tertiary">
    <div class="container">
        <span class="text-body-secondary">CopyRitghs Glodi Mietete 2025.</span>
    </div>
</footer>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "oLanguage": {
                "sLengthMenu": "Afficher MENU Enregistrements",
                "sSearch": "Rechercher: ",
                "sInfo": "Total de TOTAL enregistrements (_END_ / _TOTAL_)",
                "oPaginate": {
                    "sNext": "Suivant",
                    "sPrevious": "Précédent"
                }
            }
        });
    });
</script>

<script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>