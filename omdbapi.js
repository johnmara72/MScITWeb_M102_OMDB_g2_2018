/*jslint browser: true*/
/*global $, jQuery*/









function omdbApi() {
    console.log("----------------------------");
    "use strict";
    var title, year, x, yearParam, image, searchValue, movieId, res;
    
    title = document.getElementById("ttl").value;
    year = document.getElementById("yr").value;
    searchValue = title.replace(/ /g, "+");
   
    if (year){
        yearParam= '&y='+year;
    }else{ 
        yearParam='';
    }
    
    document.getElementById('selection_images').innerHTML = '';
    
    $.getJSON('http://www.omdbapi.com/?s=' + searchValue + yearParam + '&apikey=5b0f2222', (response =>{
                 console.log(response);
        response.Search.forEach(movie => {
            var imagesdiv=document.getElementById("selection_images");
            image = movie.Poster;
            res=response.Response;
           
            var imageTag=document.createElement("img");
            if (image !== "N/A") {
                imageTag.src=image;
            }else{                
                imageTag.src='search.png';
            }
            imageTag.width="170";
            imageTag.height="250";
            imageTag.title=movie.Title;
            imageTag.dataset.movieid=movie.imdbID;
            imageTag.addEventListener('click',(event) =>{
                var imageClicked = event.target;
                $.post("insertpref.php",
                       {
                        movie_id:imageClicked.dataset.movieid
                        },
                function(data, status){
                    if(status === 'success' )
                alert("movie has been added");
    });
            })
            imagesdiv.appendChild(imageTag);
            
             console.log(imageTag);
        })
            
            
        })
    );
  
    x = ('http://www.omdbapi.com/?s=' + searchValue + yearParam + '&apikey=5b0f2222');
    document.getElementById("demo").innerHTML = x;
    
       
}




/*
function check() {
    var choice = document.getElementsByName("choose");
    var k = choice.length;
  
    for(i=0; i<k; i++) {
        if(choice[i].checked){
            console.log(choice[i].value);
            if (choice[i].value == "like") {
                document.getElementById("poster").style.borderColor="#00b10f";
            }
            if (choice[i].value == "nah") {
                document.getElementById("poster").style.borderColor="#b10000";
            }
            
        }
    }
    
}
*/

function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {      
        $.get( "getpref.php?q="+str, function( data ,status) {
            console.log(data);
               if (status === "success") {
                document.getElementById("txtHint").innerHTML = data;
            }
        });
    }
}
