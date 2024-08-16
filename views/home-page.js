

var command_bar = document.getElementById("command-bar");
var create_project_button = document.getElementById("create-project");
var delete_project_button = document.getElementById("delete-project");
var log_out_button = document.getElementById("log-out");

var projects = document.getElementById("projects");

var filter_text_box = document.getElementById("filter_text");


var create_button_on = false;
var delete_mode = false;

var projData = [];

var hover_article_info = false;

var hover_project_info = false;

var onHover_project_info = [];

var global_uid = null;

var currentData = null;

let mode = false;
let tried = false;

count = 0

console.log("yipsssss");

customElements.define(
    "project-article",
    class paint extends HTMLElement
    {
        constructor()
        {
            super()
            let temp = document.getElementById("article-template").content;

            const shadowRoot = this.attachShadow({mode : "open"});
            shadowRoot.append(temp.cloneNode(true));

        }
    }
);

customElements.define(
    "project-info",
    class project_info extends HTMLElement
    {
        constructor()
        {
            super()

            let temp_content = document.getElementById("info-template").content;

            let shadow = this.attachShadow({mode : "open"});
            shadow.append(temp_content.cloneNode(true));
        }
    }

)
function f_hover_project_info()
{
    onHover_project_info.push("1");
    console.log("shush");
}
function f_leave_project_info()
{
    onHover_project_info.pop();
}


function clicked()
{
    id = this.childNodes[this.childNodes.length-1].textContent;
    console.log(this.childNodes[this.childNodes.length-1].textContent);

    this.outerHTML = "";
    let form = new FormData();
    
    form.append("id", this.childNodes[this.childNodes.length-1].textContent);


    fetch("deleteProject", {
        "method" : "POST",
        
        "body" : form
    })
    create_project_info();
}

function hover(ev)
{
    ev.stopPropagation();
    tried = true;
    mode = true;
    this.style.color="red";
    return;
}
function mouseLeft(ev)
{
    ev.stopPropagation();
    mode = false;
    this.style.color = "black";
    return;
}
function finalClick()
{

    console.log("done")

    if (mode == false)
        {
            delete_mode = false;

            console.log("NOMORE");
            remove_delete_listeners();

        console.log("succesfful termination of delete mode");
        console.log("deletemode is " + delete_mode);

        }
    return ;


}





function add_delete_listeners()
{
    document.querySelectorAll("project-article").forEach(function(button) {
        console.log("sandazed");
        button.addEventListener("mousemove", hover)
        button.addEventListener("mouseleave", mouseLeft);
        button.addEventListener("click", clicked)

    });
    document.addEventListener("click", finalClick);
    return;
}

function remove_delete_listeners()
{
    document.removeEventListener("click",finalClick)
    document.querySelectorAll("project-article").forEach(function(btn)
    {
        btn.removeEventListener("mousemove", hover);
        btn.removeEventListener("click", clicked);
        btn.removeEventListener("mouseleave", mouseLeft);
        
    })
    return;
}

function create_project_info(ev)
{

    if (delete_mode == false && create_button_on == false)
        {
            index  = ev.currentTarget.count;
            elem = projData[index];
            console.log(elem);
            let proj_elem = document.createElement("project-info");
        
            let info_elem = proj_elem.shadowRoot.getElementById("info");
            let p_title = document.createElement("p");
        
            p_title.setAttribute("slot", "title");
            p_title.textContent = elem["title"];
        
            proj_elem.appendChild(p_title);
        
        
            let p_description = document.createElement("p");
        
            p_description.setAttribute("slot", "description");
            p_description.textContent = elem["description"];
            proj_elem.appendChild(p_description);
        
        
            let p_start_date = document.createElement("p");
        
            p_start_date.setAttribute("slot", "start_date");
            p_start_date.textContent = elem["start_date"]
        
            proj_elem.appendChild(p_start_date);
        
        
            let p_end_date = document.createElement("p");
        
            p_end_date.setAttribute("slot", "end_date");
            p_end_date.textContent = elem["end_date"];
        
            proj_elem.appendChild(p_end_date);
        
        
            let p_phase = document.createElement("p");
        
            p_phase.setAttribute("slot", "phase");
            p_phase.textContent = elem["phase"];
        
            proj_elem.appendChild(p_phase);
        
            document.body.appendChild(proj_elem);
        
            count = 0;
            
            info_elem.addEventListener("mouseenter", f_hover_project_info);
            info_elem.addEventListener("mouseleave", f_leave_project_info);
        }


}

function remove_project_info()
{
    let list = document.querySelectorAll("project-info")
    list.forEach(x => x.innerHTML = "");
}

customElements.define(
    "create-button",
    class create_button extends HTMLElement
    {
        constructor()
        {
            super()
           
   
        }
        connectedCallback()
        {
            // let username = '<%=Session["username"]%>';
            // let password= '<%=Session["password"]%>';

            this.innerHTML = `<div id="create-project-box">
            <h2>Project Details</h2>
            <form action="/addProject" method="POST" id="add-proj">
            <p>Title:</p> <input type="text" name="title" id="f_title"></input>
            <p>Description</p> <input type="text" name="description" id="f_description"></input>
            <p>Start Time:</p> <input type="date" name="start_time" id="f_start_date"></input>
            <p>End Time:</p> <input type="date" name="end_time" id="f_end_date"></input>
            <label for="phase">Choose Phase</label>

            <select name="phase" id="f_phase">
            
            <option value="development">Development</option>
            <option value="design"">Design</option>
            <option value="testing">Testing</option>
            <option value="deployment">Deployment</option>
            <option value="complete">Complete</option>

            </select>
            <input type="submit" text="submit" value="Submit"/>
            
            </form>
        </div>`;

        let elem = document.getElementById("add-proj").addEventListener("submit", validate_proj);


        }
    }
)

function validate_proj(ev)
{
    ev.preventDefault()
    console.log("helloo");
    let elem = document.getElementById("add-proj")

    let start_date = document.getElementById("f_start_date");
    let end_date = document.getElementById("f_end_date");


    if (new Date(start_date.value) > new Date(end_date.value))
    {
            alert("End date must be smaller than beginning date");
            return;
    }
    let data = new FormData();

    let f_description = document.getElementById("f_description");
    let f_title = document.getElementById("f_title");
    let f_start_date = document.getElementById("f_start_date");
    let f_end_date = document.getElementById("f_end_date");
    let f_phase = document.getElementById("f_phase");


    data.append("title", f_title.value);
    data.append("start_date", f_start_date.value);
    data.append("end_date", f_end_date.value);
    data.append("phase", f_phase.value);
    data.append("description", f_description.value);


    fetch("/pAddProject",
        {
            method: "POST",
            body: data
        }
    ).then(x=>x.json()).then(function(x)
{
let stat = x["Status"]
if (stat == "BAD")
    {
        alert(x["error"]["errorMessage"]);
    }

else
{
    window.location.replace("main");
}
}
)

}


function createArticle(p_name, p_description, id, counter)
{
    let article_elem = document.createElement("project-article");
    article_elem.count = counter;

    console.log("name is " + p_name);
    console.log("desc is " + p_description);

    let title = document.createElement("span");
    title.setAttribute("slot", "title")
    title.textContent = p_name;
    
    let description = document.createElement("span");
    description.setAttribute("slot", "description");
    description.textContent = p_description;

    let hiddenP = document.createElement("p");
    hiddenP.setAttribute("hidden", "true");
    hiddenP.textContent = id;
    
    article_elem.appendChild(description);
    article_elem.appendChild(title);
    article_elem.appendChild(hiddenP);

    projects.append(article_elem);
   

    article_elem.addEventListener("mousemove", articleInfo);
    article_elem.addEventListener("mouseleave", articleInfo_leave);
    article_elem.addEventListener("click", create_project_info);
}

function createItems(data, reg=".*")
{
    if (reg != ".*")
    {
        reg = ".*".concat(reg);

        reg = reg.concat(".*");
        console.log("regex is " + reg);
    }
    let userRegex = new RegExp(reg, "i");
    console.log("noinnit")
    if (data.length != 0)
        {
    console.log(data);
    console.log("sxxxx");
    projData = data;

    counter = 0;
    data.forEach(element => {
        console.log(element["title"])
        if (userRegex.test(element["title"])== true || userRegex.test(element["description"]) )
        {

        
        createArticle(element["title"], element["description"], element["pid"], counter)
        counter = counter+1;
        global_uid = element["uid"];
        }
    });
    console.log("yh");

    

    console.log("yh");
}
else
{
    console.log("no projects");
    projects.innerHTML = projects.innerHTML += "<h3>There are no projects</h3>";
}
}    

function articleInfo_leave()
{
    hover_article_info = false;

    console.log(this.shadowRoot.getElementById("info-box").classList.remove("fade"));

}
function articleInfo()
{
    hover_article_info = false;

    if (delete_mode == false)
        {
            console.log(this.shadowRoot.getElementById("info-box").classList.add("fade"));

        }

}
function create_project()
{
    if (create_button_on == false)
        {
            console.log("Creating project...");
            let elem = document.createElement("create-button");
            document.body.appendChild(elem);
        }
        else
        {
            let elemList = document.querySelectorAll("create-button").forEach(x => x.innerHTML = "");
            console.log("yh");
        }
        create_button_on =  !create_button_on;


}
function deleteProjectsVisual()
{
    let list = document.querySelectorAll("project-article");
    for (i = 0; i < list.length; i++)
    {
        list[i].outerHTML = "";
    }
}
function db_delete_proj(id)
{
    fetch()
}
function delete_project(ev)
{
    console.log(" setting pressed");


    if (delete_mode == true)
    {
        ev.stopPropagation();
        mode = false;
        tried = true;
        finalClick();   
        delete_mode = false;
        return ;
    }
    mode = false;
    tried = false;

    console.log("turned ON")
    delete_mode = true;
    let list = document.querySelectorAll("create-button");
    for (i = 0; i < list.length; i++)
    {
        list[i].outerHTML = "";
    }
    console.log("Deleting project...");
    setTimeout(()=>add_delete_listeners(),100);

 


  
    return;




}   


function logout()
{
    console.log("printMe!!");
    // fetch("./logout").then(result => result.text()).then(tx =>convertPage(tx));
    loginPage();

}
function loginPage()
{
    window.location.replace("logout");

}
function convertPage(b_content)
{

// Simulate a mouse click:
// window.location.replace("logout");
}


function globalClick()
{
    console.log("yep")
    console.log(onHover_project_info.length)
    console.log(document.querySelectorAll("project-info").length)
    if (onHover_project_info.length == 0 && delete_mode == false && document.querySelectorAll("project-info").length != 0)
        {
            count = count + 1;
            console.log("Nearly del");
            console.log("count is " + count);
            if (count >= 2)
                {
                    console.log("delete now");
                    document.querySelectorAll("project-info").forEach(function(b)
                    {
                        b.shadowRoot.innerHTML = "";
                    });
                        console.log("yeassa");
                }


         
        }
}
function cleanItems(text)
{
    deleteProjectsVisual();
    createItems(currentData,text)
}
function textChange(event)
{
    console.log("text has changed");
    let text = event.target.value;
    deleteProjectsVisual();
    setTimeout(()=>cleanItems(text),100);
}


// This function will ensure that we remove all existing items and then add it; 
// utilising a wrapper pattern


// Program Entry Here

fetch("/port").then((data) => 
{ 
    
    return data.json();

}).then((x) => { 
    currentData = x;
    createItems(currentData);});


document.body.addEventListener("click", globalClick);
create_project_button.addEventListener("click", create_project);
delete_project_button.addEventListener("click", delete_project);
log_out_button.addEventListener("click", logout)

filter_text_box.addEventListener("input", textChange);

window.onerror = function(error, url, line) {
    controller.sendLog({acc:'error', data:'ERR:'+error+' URL:'+url+' L:'+line});
};
