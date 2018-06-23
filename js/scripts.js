const ulListItem = document.querySelector("#list");
/**
 * POST request to save a new todo item to the db, append it to the <ul> element on callback
 * @param {*} form
 */
const newItem = form => {
  var xhr = new XMLHttpRequest();
  xhr.onload = () => {
    if (xhr.status == 200) {
      alert("Todo successfully saved.");
      document.querySelector('#empty-todos-state') ? document.querySelector('#empty-todos-state').remove() : '';
      let todo = JSON.parse(xhr.responseText);
      todo["item"] = form.item.value;
      todo["priority"] = form.priority.value;
      ulListItem.insertAdjacentHTML("beforeend", getListTemplate(todo));
    } else {
      alert(xhr.responseText ? xhr.responseText : "an error has occurred Please check your internet connection");
    }
  };
  /**
   * if an error occurs show it to them if a message exists
   * else tell the user to check their internet connection
   */
  xhr.onerror = () => {
    alert(xhr.responseText ? xhr.responseText : "an error has occurred Please check your internet connection");
  };
  xhr.open(form.method, form.action, true);
  xhr.send(new FormData(form));
  return false;
};
/**
 * Ajax request to load the todos
 */
const loadTodos = () => {
  var xhr = new XMLHttpRequest();
  xhr.onload = () => {
    if (xhr.status == 200) {
      document.querySelector('#loader').remove(); //remove the loader
      let todos = JSON.parse(xhr.responseText);
      if (todos.length) {
        for (var index in todos) {
          //append todos
          let todo = todos[index];
          ulListItem.insertAdjacentHTML("beforeend", getListTemplate(todo));
        }
      } else {
        document.querySelector('#empty-todos-state').style.display = 'block';
      }
  } else {
    document.querySelector('#loader').remove(); //remove the loader
    alert("error loading todo items");
  }
  };
  xhr.onerror = () => {
    document.querySelector('#loader').remove(); //remove the loader
    alert("error loading todo items");
  };
  xhr.open("post", "functions.php?method=get_items", true);
  xhr.send();
};
/**
 * POST along with the todoId as payload to mark a todo item as completed
 * @param {int} todoId 
 */
const markAsCompleted = todoId => {
  let list = document.querySelector("li#todo-" + todoId);
  var xhr = new XMLHttpRequest();
  xhr.onload = () => {
    if (xhr.status == 200) {
      list.querySelector(".button").remove();
      list.classList.add("complete");
    } else {
      alert("an error occured while trying to mark this todo item as completed");
    }
  }
  xhr.open("post", "functions.php?method=mark_todo_as_complete", true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('todoId='+todoId);
};

const getListTemplate = todo => {
  return `<li id="todo-${todo.id}" class="${todo.is_completed == 1 ? "complete" : "incomplete"}">
            <span title="priority" class="priority">${todo.priority}</span>
            <span class="item">${todo.item}</span>
            ${todo.is_completed == 1 ? "" : '<a onclick="markAsCompleted(' + todo.id + ')" class="button">Complete</a>'}
          </li>`;
};

/**
 * Load todos!
 */
loadTodos();
