/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
        function checkAll(obj) {
          'use strict';
          // Получаем NodeList дочерних элементов input формы:
          var items = obj.form.getElementsByTagName("input"),
              len, i;
          // Здесь, увы цикл по элементам формы:
          for (i = 0, len = items.length; i < len; i += 1) {
            // Если текущий элемент является чекбоксом...
            if (items.item(i).type && items.item(i).type === "checkbox") {
              // Дальше логика простая: если checkbox "Выбрать всё" - отмечен
              if (obj.checked) {
                // Отмечаем все чекбоксы...
                items.item(i).checked = true;
              } else {
                // Иначе снимаем отметки со всех чекбоксов:
                items.item(i).checked = false;
              }
            }
          }
        }
        
        function price_multiple()
        {
            var a = document.getElementById("hours");
            var b = document.getElementById("tax");	
            var c = document.getElementById("price");	
            c.value = parseInt(a.value) * parseInt(b.value);	
        }

//        function checkfordelete(obj) 
//        {
//            'use strict';
//            // Получаем NodeList дочерних элементов input формы:
//            var items = obj.form.getElementsByTagName("input"),
//                len, i;
//            // Здесь, увы цикл по элементам формы:
//            for (i = 0, len = items.length; i < len; i += 1) 
//            {
//            // Если текущий элемент является чекбоксом...
//                if (items.item(i).type && items.item(i).type === "checkbox") 
//                {
//                    if(items.item(i).checked)
//                    {
//                        confirm("?");
//                        break;
//                    }
//                }
//            }
//        }