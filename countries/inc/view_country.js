// Функция для получения данных из БД и ассинхронного вывода их на экран страницы, а также удаления с экрана
const button = document.querySelector('button');

button.addEventListener('click', function (){
    let table = document.querySelector('.table_countries');
    if (!table) {
        let xhr = new XMLHttpRequest();    
        xhr.open('GET','viewCountry.php',true); 
        xhr.setRequestHeader('Content-type','application/x-form-urlencode'); 

        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                document.getElementById('countries').innerHTML = xhr.responseText;
            }
        }    
        xhr.send(null);
    } else  table.remove();
})