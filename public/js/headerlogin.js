function now() {

    const admin = document.getElementById('admin')
    const attendance = document.getElementById('attendance')

    console.log('is it triggering ?')

    if(window.location.pathname === "/") {

        admin.style.borderBottom = "1px solid black"
        admin.style.borderRadius = "0px"
        admin.style.color = "black"

    } else if(window.location.pathname === "/attendancelogin") {

        attendance.style.borderBottom = "1px solid black"
        attendance.style.borderRadius = "0px"
        attendance.style.color = "black"

    }

}

let count = 0;   
function fixing() {

    console.log('menuTriggered ?')

    const divMenu = document.getElementById('divMenu');
  

    if(count == 0) {
        count++
        divMenu.style.display = "block"

    } else {

        count = 0
        divMenu.style.display = "none"

    }

}