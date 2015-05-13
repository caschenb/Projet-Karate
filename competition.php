
<HTML>
  <head>
    <title>Ceci est le titre de la page</title>
    <script type="text/javascript">
      function catsel(sel) {
        //if (sel.value=="-1" ) return;
        var opt=sel.getElementsByTagName("option" );
        for (var i=0; i<opt.length; i++) {
          var x=document.getElementById(opt[i].value);
          if (x) x.style.display="none";
        }
        var cat = document.getElementById(sel.value);
        if (cat) cat.style.display="block";
      }
    </script>
  </head>
  <body>

    <table>
      <tr>
        <td>
        Faites un choix :
        </td>
        <td>
          <select name="choice" onchange="catsel(this)">
          <!--<option value="-1">None</option>!-->
            <option value="1">Créer</option>
            <option value="2">Modifier</option>
            <option value="3">Supprimer</option>
            <option value="4">Rechercher 4</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="1" style="display:block">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire création</td></tr></table>
          </div>
          <div id="2" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire modification</td></tr></table>
          </div>
          <div id="3" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire suppression</td></tr></table>
          </div>
          <div id="4" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire rechercher</td></tr></table>
          </div>
        </td>
      </tr>
    </table>
  </body>
</html>
