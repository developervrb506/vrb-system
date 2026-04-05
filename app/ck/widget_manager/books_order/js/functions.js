


function update_status(input){

	    var valueInput = input.value;

        // Obtener el estado del input
        var stateInput = input.checked;

        // Imprimir el valor y el estado en la consola
        //console.log('Value  input:', valorInput);
        //console.log('State  input:', estadoInput);
        const status = new Array(); 
		status.push({
              	id: valueInput,
              	status : stateInput
              });

		let formData = new FormData();
            formData.append('id', valueInput);
            formData.append('status', stateInput);
            formData.append('action', 'status');
            axios.post('data.php',formData)
          
            .then(res => console.log(res))
            .catch(err => console.log(err));

}

window.onload = () => {



	const sortable = new Sortable.default(document.querySelectorAll('ul'),{
       draggable: 'li'
	});

    //sortable.on('sortable:start', ()=> console.log('start'));
    //sortable.on('sortable:sorted', ()=> console.log('ordena'));
    sortable.on('sortable:stop', ()=> {
          setTimeout(()=> {
          	const books =  document.getElementsByClassName('book');
            //console.log(books);
            const sortedData = new Array();

           [...books].forEach((book,index)=>{
              sortedData.push({
              	id: book.getAttribute('data-id'),
              	order : index
              });
                    
            
           //console.log(book.getAttribute('data-id'),index);
           })

           let formData = new FormData();
           formData.append('data', JSON.stringify(sortedData));
           formData.append('action', 'order');
          // console.log(JSON.stringify(sortedData));
           axios.post('data.php',formData)
              .then(res => console.log('Order'+res))
              .catch(err => console.log(err));

          },100); // When an element is Moved it create 2 temporal elements, so this timer is to solve that
    });
          
}


