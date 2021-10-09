"use strict";
{
  const checkboxes = document.querySelectorAll("input[type='checkbox']");
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      const {
        dataset: { id, token },
      } = checkbox;

      fetch("?action=toggle", {
        method: "POST",
        body: new URLSearchParams({
          id: id,
          token: token,
        }),
      });
    });
  });

  const deletes = document.querySelectorAll(".delete");
  deletes.forEach((span) => {
    span.addEventListener("click", () => {
      if (!confirm("Are you sure?")) {
        return;
      }
      const {
        dataset: { id, token },
      } = span;

      fetch("?action=delete", {
        method: "POST",
        body: new URLSearchParams({
          id: id,
          token: token,
        }),
      });

      span.parentNode.remove();
    });
  });

  const purge = document.querySelector(".purge");
  purge.addEventListener("click", () => {
    if (!confirm("Are you sure?")) {
      return;
    }
    const {
      dataset: { token },
    } = purge;

    fetch("?action=purge", {
      method: "POST",
      body: new URLSearchParams({
        token: token,
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
