// public/js/car_filter.js

$(function() {
    var minPrice, maxPrice; // Déclaration des variables pour stocker les valeurs du slider
    var minMileage, maxMileage; // Déclaration des variables pour stocker les valeurs du slider
    var minYear, maxYear; // Déclaration des variables pour stocker les valeurs du slider

    // Slider Price
    $("#slider-range").slider({
      range: true,
      min: 0,
      max: 35000,
      values: [0, 35000],
      slide: function(event, ui) {
        minPrice = ui.values[0]; // Mettre à jour la valeur minimale
        maxPrice = ui.values[1]; // Mettre à jour la valeur maximale
        
        $("#amount").val(minPrice + " € - " + maxPrice + " €");
      }
    });

    // Initialisation des valeurs
    minPrice = $("#slider-range").slider("values", 0);
    maxPrice = $("#slider-range").slider("values", 1);
     $("#amount").val(minPrice + " € - " + maxPrice + " €");


    // Slider Mileage
    $("#slider-range-mileage").slider({
        range: true,
        min: 0,
        max: 100000,
        values: [0, 100000],
        slide: function(event, ui) {
          minMileage = ui.values[0]; // Mettre à jour la valeur minimale
          maxMileage = ui.values[1]; // Mettre à jour la valeur maximale
          
          $("#mileage").val(minMileage + " km - " + maxMileage + " km");
  
        }
      });
   // Initialisation des valeurs
   minMileage = $("#slider-range-mileage").slider("values", 0);
   maxMileage = $("#slider-range-mileage").slider("values", 1);
   $("#mileage").val(minMileage + " km - " + maxMileage + " km");


    // // Slider Year
     $("#slider-range-year").slider({
         range: true,
         min: 2018,
         max: 2024,
         values: [2018, 2024],
         slide: function(event, ui) {
         minYear = ui.values[0]; // Mettre à jour la valeur minimale
         maxYear = ui.values[1]; // Mettre à jour la valeur maximale
        
         $("#year").val(minYear + " - " + maxYear);

         }
     });
     // Initialisation des valeurs
        minYear = $("#slider-range-year").slider("values", 0);
        maxYear = $("#slider-range-year").slider("values", 1);
        $("#year").val(minYear + " - " + maxYear);


// Filtre avec le SLIDER V3 
window.addEventListener("mouseup", (e) => {
  FiltreCar();
});

 function FiltreCar() { 
 minPrice = $("#slider-range").slider("values", 0);
 maxPrice = $("#slider-range").slider("values", 1);
 minMileage = $("#slider-range-mileage").slider("values", 0);
 maxMileage = $("#slider-range-mileage").slider("values", 1);
 minYear = $("#slider-range-year").slider("values", 0);
 maxYear = $("#slider-range-year").slider("values", 1);


 $.ajax({
     url: '/loadcar/',
     type: 'GET',
     //data: { minPrice: minPrice, maxPrice: maxPrice,minMileage:minMileage,maxMileage:maxMileage},
     data: { minPrice: minPrice, maxPrice: maxPrice, minMileage:minMileage, maxMileage:maxMileage, minYear:minYear, maxYear:maxYear },
     success: function(data) {
     
     console.log(data)
         // Mettre à jour l'interface utilisateur avec les résultats filtrés
         // (Assuming you have a function to render the results)
       $('#filteredResults').html(data);
     },
     error: function(xhr, status, error) {
        
     }
  });
}
});






















// // Filtre avec le BOUTON V1 
// $('#filterButton').click(function() {
//     const minPrice = $('#minPriceInput').val();
//     const maxPrice = $('#maxPriceInput').val();
    
    
//     $.ajax({
//         url: '/loadcar/',
//         type: 'GET',
//         data: { minPrice: minPrice, maxPrice: maxPrice },
//          success: function(data) {
        
//         console.log(data)
//             // Mettre à jour l'interface utilisateur avec les résultats filtrés
//             // (Assuming you have a function to render the results)
//           $('#filteredResults').html(data);
//         },
//         error: function(xhr, status, error) {
           
//         }
//     });
// });