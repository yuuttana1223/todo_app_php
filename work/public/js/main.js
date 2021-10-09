"use strict";
{
  const token = document.querySelector("main").dataset.token;
  const input = document.querySelector("[name='title']");
  const ul = document.querySelector("ul");

  ul.addEventListener("click", (e) => {
    if (e.target.type === "checkbox") {
      fetch("?action=toggle", {
        method: "POST",
        body: new URLSearchParams({
          id: e.target.parentNode.dataset.id,
          token,
        }),
      })
        .then((res) => {
          if (!res.ok) {
            throw new Error();
          }
        })
        .catch((error) => {
          alert(error.message);
          location.reload();
        });
    }

    if (e.target.classList.contains("delete")) {
      if (!confirm("Are you sure?")) {
        return;
      }

      fetch("?action=delete", {
        method: "POST",
        body: new URLSearchParams({
          id: e.target.parentNode.dataset.id,
          token,
        }),
      });

      e.target.parentNode.remove();
    }
  });

  input.focus();

  const addTodo = (id, titleValue) => {
    const li = document.createElement("li");
    li.dataset.id = id;
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    const title = document.createElement("span");
    title.textContent = titleValue;
    const deleteSpan = document.createElement("span");
    deleteSpan.textContent = "削除";
    deleteSpan.className = "delete";

    li.appendChild(checkbox);
    li.appendChild(title);
    li.appendChild(deleteSpan);

    const ul = document.querySelector("ul");
    ul.insertBefore(li, ul.firstChild);
  };

  document.querySelector("form").addEventListener("submit", (e) => {
    e.preventDefault();
    const title = input.value;

    fetch("?action=add", {
      method: "POST",
      body: new URLSearchParams({
        title,
        token,
      }),
    })
      .then((res) => res.json())
      .then((json) => {
        addTodo(json.id, title);
      });

    // addTodoよりも先に行われる(非同期)。
    input.value = "";
    input.focus();
  });

  const purge = document.querySelector(".purge");
  purge.addEventListener("click", () => {
    if (!confirm("Are you sure?")) {
      return;
    }

    fetch("?action=purge", {
      method: "POST",
      body: new URLSearchParams({
        token,
      }),
    });

    const listItems = document.querySelectorAll("li");
    listItems.forEach((listItem) => {
      if (listItem.firstElementChild.checked) {
        listItem.remove();
      }
    });
  });
}
