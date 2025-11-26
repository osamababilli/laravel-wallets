import Swal from "sweetalert2";

window.Swal = Swal;

document.addEventListener("livewire:init", () => {
    Livewire.on("delete-confirm", (e) => {
        console.log(e[0].id); // يطبع الـ ID والرسالة

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton:
                    "focus:outline-none text-white bg-blue-700 hover:bg-blue-800  font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800",
                cancelButton:
                    "focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900",
            },
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
            .fire({
                title: e[0].title,
                text: e[0].message,
                icon: "warning",
                showCancelButton: true,
                theme: "auto",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch("delete-confirmted", { id: e[0].id });
                }
            });
    });
});
