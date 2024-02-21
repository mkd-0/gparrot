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

   getFilteredCars(minPrice, maxPrice, minMileage, maxMileage, minYear, maxYear)
    
    }




 function getFilteredCars(minPrice, maxPrice,
    minMileage, maxMileage, minYear, maxYear) {
   console.log(minPrice +"/",maxPrice);
   console.log(minMileage +"/",maxMileage);
   console.log(minYear +"/",maxYear);

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
   
    filterCars(response['allCarIds'], 
    response['filteredCarsIds'])
     //filterCars(response.allCarIds, 
    //    response.FilteredCarsIds)
   }).fail((error) => {
     alert("Une erreur est survenue lors du filtrage" . error)
   })
 }
 
 function filterCars(allCarIds, FilteredCarsIds) {
   allCarIds.forEach((carId) => {
    console.log(carId);
    console.log(FilteredCarsIds);
     const carDiv = document.querySelector("#car-" + carId)
     // const carDiv = document.querySelector('[id="car-' + carId + '"]')
     //const containsObject = 
     //FilteredCarsIds.some((obj) => obj.id === carId); 
     //if (containsObject) 
     //{
      if (FilteredCarsIds.includes(carId)) {  
     carDiv.style.display = 'block'
     } else {
       carDiv.style.display = 'none'
     }
   })
 }