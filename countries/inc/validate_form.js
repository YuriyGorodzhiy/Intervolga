window.addEventListener('load', function (){
    alert('Поля "Название страны", "Столица страны", "Государственный язык" заполняются только кириллицей, \
начиная с заглавной буквы, с использованием пробела или тире. Длина строк должна составлять от 3 до 60 символов.\r\
Поле "Численность населения" не должно превышать 10 символов.');

// Находим внутри объекта document элемент страницы <form> и записываем его в переменную "form"
const form = document.querySelector('form');

// Создаём функцию обработки и оправки данных на сервер из формы 
form.addEventListener('submit', formSend);

// Функция для асинхронной отправки проверенных данных в БД и получения ответа от сервера на запрос
async function formSend(e) {
    e.preventDefault();

    let error = formValidade(form);

    let formData = new FormData(form);

    if (error === 0){
        form.classList.add('_sending');
        let response = await fetch('addCountry.php', {
            method: 'POST',
            body: formData
        });
        if (response.ok) {
            let result = await response.json();
            alert(result.message);
            form.reset();
            form.classList.remove('_sending');
            let button = document.querySelector('.btn_table');
            button.style.display = "block";
        } else {
            alert("Ошибка при отправке данных формы на сервер.");
            form.classList.remove('_sending');
        }
    } else {
        alert('Проверьте заполненность формы.');
    }
}

// Функция валидации обязательных полей input текстого типа
function formValidade() {
    let error = 0;
    let inputText = document.querySelectorAll('[type="text"]');
    let textError = document.querySelectorAll('.error');
     
    let reg = /^[А-ЯЁ][а-яА-ЯёЁ\s-]+[а-яё]$/;

    for (let i = 0; i < inputText.length; i++) {
        if (textError[i]) {
            textError[i].remove();
        }
        
        let inputTextValue = inputText[i].value;
        // Проверям поля на пустоту 
        if (inputTextValue == '') {
            inputText[i].insertAdjacentHTML('afterend', '<div class="error">Заполните поле.</div>');
            error++;
        } else {
            // Проверям текст введённые в поля на соответствие регулярному выражению
            if (!reg.test(inputTextValue)) {
                inputText[i].insertAdjacentHTML('afterend', '<div class="error">Некорректный ввод текста.</div>');
                error++;
            }
        }
    }
    return error;
}
});