<header>
    <span>
        <a id="logo" href="../frontend/home.php"></a>
        <a id="primo" href="../frontend/upload.php">Upload</a>
    </span>
    <form id="src_block" action="#src_results" method="get">
      <select class="src_type" name="src_type">
          <option value="v">Video</option>
          <option value="a">Audio</option>
          <option value="i">Immagine</option>
          <option value="u">Utente</option>
          <option value="c">Canale</option>
      </select>
      <input id="srcbtn" type="submit">
      <input id="src" type="text" name="src_txt" placeholder="Cerca...">
      <a id="avanzata" href="#ricerca_avanzata">Avanzata</a>
    </form>
    <span>
        <?php
            echo "<a href='../frontend/user.php?user=".$_SESSION["email"]."'>".$_SESSION["nome"]."</a>";
        ?>
        <a href="../backend/esci.php">Esci</a>
    </span>
</header>