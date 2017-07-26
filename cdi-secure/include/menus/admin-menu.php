<script>
    function show_hide() {
        var x = document.getElementById('dropdown-content');
        if (x.style.display === 'none') {
            x.style.display = 'block';
        } else {
            x.style.display = 'none';
        }
    }
</script>
<div class="admin-nav" id='scroll'>
    <ul>
        <a href="admin-home.php">
            <li <?php if(basename($_SERVER['PHP_SELF'])=='admin-home.php') echo "class='active'"; ?>> Home</li>
        </a>
        <a href="camere.php">
            <li <?php if(basename($_SERVER['PHP_SELF'])=='camere.php') echo "class='active'"; ?>> Rezervări camere 
            <?php
                $sql = "SELECT * FROM rezervari_camere WHERE confirmed = '0'";
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) > 0)
                { 
                    echo "<span class='new'>New!</span> ";
                }
            ?>
            </li>
        </a>
        <?php
            $extended = '';
            if(basename($_SERVER['PHP_SELF'])=='rezervari_carti.php' || basename($_SERVER['PHP_SELF'])=='carti.php' || basename($_SERVER['PHP_SELF'])=='detalii_carte.php' || basename($_SERVER['PHP_SELF'])=='add_carte.php' || basename($_SERVER['PHP_SELF'])=='categorii.php' || basename($_SERVER['PHP_SELF'])=='imagini.php') 
                    $extended = "class='active'";
        ?>
        <div class="dropdown">
            <div <?php echo $extended;?>>
                <button class="dropbtn" onclick="show_hide();">Cărți<div class='arrow-right'></div></button>
            </div>
            <div class="dropdown-content" id='dropdown-content'>
                <a href="rezervari_carti.php">
                    Rezervări cărți
                    <?php 
                        $sql = "SELECT * FROM rezervari_carti WHERE confirmed = '0' OR confirmed = '2'";
                        $rezultat = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($rezultat) > 0)
                            echo "<span class='new'>New!</span>"; 
                    ?> 
                </a>
                <a href="carti.php">
                    Cărți
                </a> 
                <a href="add_carte.php">
                    Adaugă carte
                </a> 
                <a href="categorii.php">
                    Categorii
                </a> 
                <a href="imagini.php">
                    Imagini
                </a>
            </div>
        </div>

        <div class='extended-dropdown'>
            <a href="rezervari_carti.php">
                <li <?php if(basename($_SERVER['PHP_SELF'])=='rezervari_carti.php') echo "class='active'"; ?>> Rezervări cărți
                <?php 
                    $sql = "SELECT * FROM rezervari_carti WHERE confirmed = '0' OR confirmed = '2'";
                    $rezultat = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($rezultat) > 0)
                        echo "<span class='new'>New!</span>"; 
                ?> 
                </li>
            </a>
            
            <a href="carti.php">
                <li <?php if(basename($_SERVER['PHP_SELF'])=='carti.php' || basename($_SERVER['PHP_SELF'])=='detalii_carte.php') echo "class='active'"; ?>> Cărți
                </li>
            </a> 
            <a href="add_carte.php">
                <li <?php if(basename($_SERVER['PHP_SELF'])=='add_carte.php') echo "class='active'"; ?>> Adaugă carte
                </li>
            </a> 
            <a href="categorii.php">
                <li <?php if(basename($_SERVER['PHP_SELF'])=='categorii.php') echo "class='active'"; ?>> Categorii
                </li>
            </a> 
            
            <a href="imagini.php">
                <li <?php if(basename($_SERVER['PHP_SELF'])=='imagini.php') echo "class='active'"; ?>> Imagini </li>
            </a>
        </div>

        <a href="utilizatori.php">
            <li <?php if(basename($_SERVER['PHP_SELF'])=='utilizatori.php') echo "class='active'";?>>  Utilizatori
            <?php 
                $ok = 0;
                $sql = "SELECT * FROM users WHERE confirmed = '0'";
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) > 0)
                {
                    echo "<span class='new'>New!</span> ";
                }
            ?>
            </li>
        </a>
        <a href="../index.php">
            <li> Pagina principală </li>
        </a>
          
    </ul>
</div>
