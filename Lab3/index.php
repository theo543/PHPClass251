<html>
<title> Laboratorul 1 - Forms </title>
<body>
<FORM method="POST" action="lab2.php">
<table border=0 width="40%" align="left">
  <tr>
    <td with="30%">Nume* :</td>
    <td with="70%"><INPUT TYPE="text" name="nume"></td>
  </tr>
   <tr>
    <td>Prenume* :</td>
    <td><INPUT TYPE="text" name="prenume"></td>
  </tr>
   <tr>
    <td>Sex* : </td>
    <td> Feminin <input type="radio" name="sex" value="F"> Masculin <input type="radio" name="sex" value="M"></td>
  </tr>
  <tr>
    <td>Stare civila* :</td>
    <td>
	<select name="stare_civila">
		<option>necasatorit(a)</option>
		<option>casatorit(a)</option>
		<option>divortat(a)</option>
		<option SELECTED VALUE="">Select...</option>
	</select>
	</td>
  </tr>
    <tr>
    <td>Data nasterii* :</td>
    <td>zi: 
	<?php 
	echo '<select name="zi">';
	echo '<option selected> - </option>';
	for ($i=1; $i<=31; $i++) echo '<option>'.$i.'</option>';
	echo '</select>';
	echo  ' luna:';
	echo '<select name="luna">';
	echo '<option selected> - </option>';
	for ($i=1; $i<=12; $i++) echo '<option>'.$i.'</option>';
	echo '</select>';
	echo  ' anul:';
	echo '<select name="an">';
	echo '<option selected> - </option>';
	for ($i=1900; $i<=date('Y'); $i++) echo '<option>'.$i.'</option>';
	echo '</select>';
	?>
	</td>
  </tr>
  <tr>
    <td>Domiciliu* :</td>
    <td><textarea name="domiciliu" rows="2" cols="30" wrap="left">Strada, nr, bloc, scara, etaj, apartament</textarea></td>
  </tr>
    <tr>
    <td>Oras* :</td>
    <td><INPUT TYPE="text" name="oras"></td>
  </tr>
    <tr>
    <td>Judet* :</td>
    <td>
	<select name="judet">
		<?php
      include("../../dblogin.php");
      $link = mysqli_connect("localhost", $dbuser, $dbpass, "hr");
      unset($dbuser, $dbpass);
      
      if (!$link) {
          echo "Error: Unable to connect to MySQL.";
          exit;
      }
      
      $query="SELECT * FROM counties";
      foreach ($link->query($query) as $row) {
        $county_code = htmlspecialchars($row['county_code']);
        $county_name = htmlspecialchars($row['county_name']);
        echo "<option value=$county_code>$county_name</option>";
      }
      
      mysqli_close($link);
    ?>
		<option SELECTED VALUE="">Select...</option>
	</select>
	</td>
  </tr>
  </tr>
    <tr>
    <td>Cod postal* :</td>
    <td><INPUT TYPE="text" name="cod_postal"></td>
  </tr>
  </tr>
    <tr>
    <td>Email* :</td>
    <td><INPUT TYPE="text" name="email"></td>
  </tr>
  </tr>
    <tr>
    <td>Telefon:</td>
    <td><INPUT TYPE="text" name="telefon"></td>
  </tr>
  </tr>
    <tr>
    <td>Fax:</td>
    <td><INPUT TYPE="text" name="fax"></td>
  </tr>
    <tr>
    <td>Venit lunar:</td>
    <td>100 - 200<input type="radio" name="venit" value="100">201 - 300<input type="radio" name="venit" value="200">
	301 - 500<input type="radio" name="venit" value="300"> peste 500 <input type="radio" name="venit" value="500">
	</td>
  </tr>
    <tr>
    <td>Hobby-uri :</td>
    <td>
	<select name="hobby[]" size="3" MULTIPLE>
		<option>sport</option>
		<option>muzica</option>
		<option>lectura</option>
	</select>
	</td>
  </tr>
   </tr>
    <tr>
    <td>Newsletter* :</td>
    <td>Email:<INPUT TYPE="checkbox" NAME="vrea_mail" value="mail"> Posta:<INPUT TYPE="checkbox" NAME="vrea_posta" value="posta">
	Fax:<INPUT TYPE="checkbox" NAME="vrea_fax" value="fax">
	</td>
  </tr>
    </tr>
    <tr>
    <td><br></br></td>
    <td></td>
  </tr>
    </tr>
    <tr>
    <td><INPUT TYPE="reset" VALUE="reset"></td>
    <td><INPUT TYPE="submit" VALUE="send"></td>
  </tr>
 </table>
 </form>
</body>
</html>