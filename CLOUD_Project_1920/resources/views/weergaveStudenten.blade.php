@extends('index')

@section('eigen_inhoud')

@endsection
@yield('test')
@section('extra_inhoud')



            <div class="card">
                <div class="card-header">Ingeven van punten in een klas</div>

                <div class="card-body">
                    
                    <html>
        <hr/>
        <p>Geef de toets en punten in</p>
</html>

<form> 
    <!--- hier hoeft dus geen post enzo meer te staan, zie zoekformulier.blad.php,
    het uploaden wordt in de javascript gedaan via een get en geen POST 
    <form action="/punten/uploadPunten" method ="post">-->
    @csrf
    <!--   commentaar -->
    <table>
         <tr>
            <td> 
                 <p>Vak:</p>
                 
            </td> 
            <td>    
                <input type='text' name='vak' id='vak' value='Wiskunde' />
            </td> 
        </tr>
        <tr>
            <td> 
                 <p>Titel toets:</p>
                 
            </td> 
            <td>    
                <input type='text' name='titel' id='titel' value='Algebraisch rekenen' />
            </td> 
        </tr>
        <tr>
            <td> 
                 <p>Punten totaal:</p>
                 
            </td> 
            <td>    
                <input type='number' name='maximum' id="maximum" value='20' />
            </td> 
        </tr>
        <tr>
            <td> 
                 <p>Behaalde cijfers studenten:</p>
                 
            </td> 
           
        </tr>
        
        <?php
            for ($x = 0; $x < sizeof($studentNaam); $x++) {
                 echo "<tr>";
                 echo "<td>$studentNaam[$x] $studentVoornaam[$x]:</td>";
                 echo "<td><input type='number' name='punten[]' id='punt[$x]' value = '$x'/></td>";
                 echo "</tr>";
            }
        ?>
          <tr>
            <td> 
                
                <?php
                    $size = sizeof($studentNaam);
                    echo " <input type='hidden'  id='size' name='size' value='$size'>";
                    for ($x = 0; $x < $size; $x++) {
                        
                        echo " <input type='hidden'  id='naam[$x]' name='naam[]' value= '$studentNaam[$x]'>";
                        echo " <input type='hidden'  id='voornaam[$x]' name='voornaam[]' value= '$studentVoornaam[$x]'>";
                        echo " <input type='hidden'  id='studentennummer[$x]' name='studentennummer[]' value= '$sudentNummer[$x]'>";
                       
                }
                ?>      
            </td>
            <td> 
                    <input type='button' value="Insturen" onclick="printHelloWorld()"/>        <!-- button was submit -->
                   
            </td> 
           
        </tr>
         

    </table>  
</form>

<html>
        <p>Einde print studenten</p>
        <hr/>
</html>
@stop
                    
                </div>
            </div>
<div id="laptops"> </div>
<div id="lukas"> </div>


<script type="text/javascript">
    function printHelloWorld() {
      
       // alert(naam.value);
      
        
        txt = "Zijn de volgende gegevens correct? \n \n";
        //txt = txt + naam.value;
        //alert(txt);
        var vak = document.getElementById("vak");
        var titel = document.getElementById("titel");
        var maximum = document.getElementById("maximum");
        var size = document.getElementById("size");
        
        var hallo = document.getElementById("$studentVoornaam")
        
        var error = 0;
        var fruits = ["Banana", "Orange", "Apple", "Mango"];
        document.getElementById("laptops").innerHTML = "Controleren of het goed gaat";
        
        txt = txt + "Vak: " + vak.value +"\n";
        txt = txt + "Titel: " + titel.value+"\n";
        txt = txt + "Totale punten: " + maximum.value+"\n\n";
        var naam_a=[];
        var voornaam_a=[];
        var punten_a=[];
        var studentennummer_a=[];
        for(count = 0; count < size.value; count++) {
               var punt = document.getElementById("punt["+count+"]");
               var naam = document.getElementById("naam["+count+"]");
               var voornaam = document.getElementById("voornaam["+count+"]");
               var studentennummer = document.getElementById("studentennummer["+count+"]");
               naam_a.push(naam.value); 
               voornaam_a.push(voornaam.value);
               punten_a.push(punt.value);
               studentennummer_a.push(studentennummer.value);
               if(punt.value > parseFloat(maximum.value) || punt.value < 0){  
                    alert(punt.value + ' > ' + parseFloat(maximum.value) );
                    punt.style.backgroundColor = "red";
                    error = 1;
                } 
               
               //txt= txt + punt.value;
               txt = txt+ "Studentennummer " + studentennummer.value + " " + naam.value + " " + voornaam.value +  " heeft " + punt.value +"\n";
        }
        
        //alert(txt);
       if (error != 0){
           txt = "Er is een error, probeer opnnieuw!"
           // Op de pagina blijven om fouten te veranderen
       }
       else if (confirm(txt)) {
            txt = "You pressed OK!";
            // uploaden van de data
            // Naar de normale docenten pagina ga na dat het geupload is. 
            // Melding het is geupload je klikt op oke en dan ga je naar de normale docenten pagina. 
       } else {
            txt = "You pressed Cancel!";
            // Op de pagina blijven voor aanpassingen te doen
       }
       
       let content = {some: 'content'}
       //{naam}/{voornaam}/{studentennummer}/{punten}/{vak}/{titel}/{maximum}
       //http://127.0.0.1:8000/api/punten/uploadTest/" + naam_a + "/" + voornaam_a+ "/" + studentennummer_a + "/" + punten_a + "/" + vak.value + "/" + titel.value+ "/" +maximum.value
       //fetch("http://127.0.0.1:8000/api/punten/uploadTest/" + naam_a + "/" + voornaam_a+ "/" + studentennummer_a + "/" + punten_a +"/"+vak.value +"/" + titel.value+"/" + maximum.value + "/",
       fetch("http://127.0.0.1:8000/api/punten/uploadTest/",
           {method: "post",
           headers: {'Content-Type': 'application/json'} 
           body: JSON.stringify(content)} ) //verder werken
                .then(response => {if (response.ok) return response.text();
                                  else Promise.reject("Problem sending data");
                                  })
                .then(showLaptops)
                .catch(err => alert(err));
       
       document.getElementById("lukas").innerHTML = "TEST";
       
       alert(txt);
        
    }
       function showLaptops(jsonData){
        alert("test");
        document.getElementById("laptops").innerHTML = "Deze text";
        //document.getElementById("laptops").innerHTML = jsonData;
        alert("oke");
        
    }
    
</script>


