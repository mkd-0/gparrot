const rangeDivs = document.querySelectorAll('input[id^="slider-range"]')
if ((rangeDivs.length !== 0) && (rangeDivs !== null)) {
  rangeDivs.forEach((div) => {
    div.addEventListener('mouseup', (event) => {
     
      getElementsAndAjaxCall()
    })
  });
}

function getElementsAndAjaxCall() {
    //const minPrice = parseInt(event.currentTarget.value)
    const minPrice = parseInt($('#slider-range-price-value1').val())
    const maxPrice = parseInt($('#slider-range-price-value2').val())
    const minMileage =  parseInt($('#slider-range-mileage-value1').val())
    const maxMileage = parseInt($('#slider-range-mileage-value2').val())
    const minYear = parseInt($('#slider-range-year-value1').val())
    const maxYear = parseInt($('#slider-range-year-value2').val())
    $("#price-min").text(minPrice);
    $("#price-max").text(maxPrice);
    $("#mileage-min").text(minMileage);
    $("#mileage-max").text(maxMileage);
    $("#year-min").text(minYear);
    $("#year-max").text(maxYear);

   getFilteredCars(minPrice, maxPrice, minMileage, maxMileage, minYear, maxYear)
    
    }


 function getFilteredCars(minPrice, maxPrice,
    minMileage, maxMileage, minYear, maxYear) {

   $.ajax({
     url: '/admin/car/getFilteredCars',
     method: 'GET',
     data: {
       'minPrice': minPrice,
       'maxPrice': maxPrice,
       'minMileage': minMileage,
       'maxMileage': maxMileage,
       'minYear': minYear,
       'maxYear': maxYear
     }
   }).done((response) => {
   console.log(response);
    filterCars(response.allCarIds, 
        response.filteredCarsIds)
   }).fail((error) => {
     alert("Une erreur est survenue lors du filtrage" . error)
   })
 }
 
 function filterCars(allCarIds, filteredCarsIds) {
   allCarIds.forEach((carId) => {
    console.log(filteredCarsIds);
    const carDiv = document.querySelector('[id="car-' + carId + '"]')
   if(filteredCarsIds.length>0){
    const containsObject = 
    filteredCarsIds.some((obj) => obj.id == carId); 
    if (containsObject) 
    {
     // if (FilteredCarsIds.includes(carId)) {  
     carDiv.style.display = 'block'
     } else {
       carDiv.style.display = 'none'
     }
    }
   })
 }