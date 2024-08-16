

let delete_account = document.getElementById("delete-account");

let delete_projects = document.getElementById("delete-all-projects");

let delete_proj_container = document.getElementById("delete-project-container");

let delete_proj_middle = document.getElementById("delete-project-middle");

let confirm_button = document.getElementById("confirm-button");

let delete_button = document.getElementById("delete-button");

let reject_button = document.getElementById("reject-button");



let is_delete_gui = false;

function waitElm(query)
{
    return new Promise((resolve) =>
{
    if (document.querySelector(query)) {
        return resolve(document.querySelector(query));
    }
    const observer = new MutationObserver((evs) =>
    {
        if (document.querySelector(query))
            {
                observer.disconnect
                return resolve(document.querySelector(query))
            }
    });

    observer.observe(document.body, {            childList: true,
        subtree: true})
})
}


function Delete_Projects()
{

    delete_proj_container.style.display="none";
    is_delete_gui = false;


            fetch("/port").then((x) => x.json()).then(function (x){
                if (x!= null)
                    {
                        x.forEach(element => {
                            let data = new FormData();
                   
                       data.append("id", element["pid"])
                   
                       fetch("/deleteProject", 
                           {
                               "method" : "POST",
                               "body" : data
                           }
                       )
                       })
                    }
        });
            alert("all projects have been successfully deleted");
        }
 
    // let data = new FormData();

    // data.append("id", )

    // fetch("/deleteProject", 
    //     {
    //         "method" : "POST",
    //         "body" : data
    //     }
    // )

function delete_project_gui()
{
    if (is_delete_gui == false)
        {
            delete_proj_container.style.display = "flex";
            is_delete_gui = true;
        } 
        else{
            delete_proj_container.style.display="none";
            is_delete_gui = false;
        }
}
function reject_gui()
{
    delete_proj_container.style.display="none";
    is_delete_gui = false; 
}
const syncWait = ms => {
    const end = Date.now() + ms
    while (Date.now() < end) continue
}

function Delete_Account()
{
    confirm("Are you sure you want to delete your account?") ? fetch("/deleteAccount").then(x=>window.location.replace("/login")) :false;
}
delete_projects.addEventListener("click", delete_project_gui);
delete_account.addEventListener("click", Delete_Account);

confirm_button.addEventListener("click",Delete_Projects);

reject_button.addEventListener("click", reject_gui);
function fill_table(data)
{
    console.log(data);
    let length = data.length;
    
waitElm("#project-table").then((x)=>
    {
        data.forEach(element => {
            let row = x.insertRow(-1);
            cell_1 = row.insertCell(0)
            cell_1.textContent = element["title"];

            cell_2 = row.insertCell(1)
            cell_2.textContent = element["phase"];

            cell_3 = row.insertCell(2)
            cell_3.textContent = element["description"];




    })}


)
}

fetch("/port").then(x=>x.json()).then(fill_table)