const appContainer = document.getElementById('app-container');

// Fungsi untuk render form login
function renderLoginForm() {
    appContainer.innerHTML = `
        <div class="card p-4 mx-auto" style="max-width: 400px;">
            <h2 class="text-center mb-4">Login</h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback">Username tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Password tidak boleh kosong.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p id="errorMessage" class="text-danger text-center mt-3"></p>
        </div>
    `;

    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', handleLogin);
}

// Validasi Form
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        if (input.value.trim() === '') {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    return isValid;
}

// Handle Login
async function handleLogin(e) {
    e.preventDefault();
    const form = e.target;
    if (!validateForm(form)) return;

    const username = form.username.value;
    const password = form.password.value;

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });
        const result = await response.json();

        const errorMessage = document.getElementById('errorMessage');
        if (result.success) {
            sessionStorage.setItem('role', result.role);
            if (result.role === 'admin') {
                renderAdminDashboard();
            } else {
                renderStudentDashboard();
            }
        } else {
            errorMessage.textContent = result.message;
        }
    } catch (error) {
        console.error('Login error:', error);
    }
}

// --- Admin ---
// Render Dashboard Admin
function renderAdminDashboard() {
    appContainer.innerHTML = `
        ${getAdminNavbarHtml()}
        <div class="mt-4">
            <h1>Selamat Datang, Admin!</h1>
            <p class="lead">Ini adalah halaman dashboard admin.</p>
        </div>
    `;
    updateActiveMenu('Dashboard');
}

// Render Manajemen Mata Kuliah Admin
async function renderAdminCourses() {
    try {
        const response = await fetch('/api/admin/courses');
        const courses = await response.json();
        
        let courseListHtml = '';
        courses.forEach(course => {
            courseListHtml += `
                <tr>
                    <td>${course.id}</td>
                    <td>${course.code}</td>
                    <td>${course.name}</td>
                    <td>${course.credits}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('course', ${course.id}, '${course.name}')">Hapus</button>
                    </td>
                </tr>
            `;
        });

        appContainer.innerHTML = `
            ${getAdminNavbarHtml()}
            <div class="mt-4">
                <h1>Daftar Mata Kuliah</h1>
                <p><button class="btn btn-primary" onclick="renderCreateCourseForm()">Tambah Mata Kuliah</button></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${courseListHtml}
                    </tbody>
                </table>
            </div>
        `;
        updateActiveMenu('Manajemen Mata Kuliah');
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
}

// Render Form Tambah Mata Kuliah Admin
function renderCreateCourseForm() {
    appContainer.innerHTML = `
        ${getAdminNavbarHtml()}
        <div class="mt-4">
            <h1>Tambah Mata Kuliah Baru</h1>
            <form id="createCourseForm">
                <div class="mb-3">
                    <label for="code" class="form-label">Kode Mata Kuliah</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                    <div class="invalid-feedback">Kode tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">Nama tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="credits" class="form-label">SKS</label>
                    <input type="number" class="form-control" id="credits" name="credits" required>
                    <div class="invalid-feedback">SKS tidak boleh kosong.</div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    `;
    document.getElementById('createCourseForm').addEventListener('submit', handleCreateCourse);
}

// Handle Tambah Mata Kuliah
async function handleCreateCourse(e) {
    e.preventDefault();
    const form = e.target;
    if (!validateForm(form)) return;

    const data = {
        code: form.code.value,
        name: form.name.value,
        credits: form.credits.value,
    };

    await fetch('/api/admin/courses/store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });
    renderAdminCourses();
}

// Render Manajemen Mahasiswa Admin
async function renderAdminStudents() {
    try {
        const response = await fetch('/api/admin/students');
        const students = await response.json();

        let studentListHtml = '';
        students.forEach(student => {
            studentListHtml += `
                <tr>
                    <td>${student.id}</td>
                    <td>${student.nim}</td>
                    <td>${student.nama_lengkap}</td>
                    <td>${student.username}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="renderEditStudentForm(${student.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('student', ${student.id}, '${student.nama_lengkap}')">Hapus</button>
                    </td>
                </tr>
            `;
        });
        
        appContainer.innerHTML = `
            ${getAdminNavbarHtml()}
            <div class="mt-4">
                <h1>Daftar Mahasiswa</h1>
                <p><button class="btn btn-primary" onclick="renderCreateStudentForm()">Tambah Mahasiswa</button></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${studentListHtml}
                    </tbody>
                </table>
            </div>
        `;
        updateActiveMenu('Manajemen Mahasiswa');
    } catch (error) {
        console.error('Failed to fetch students:', error);
    }
}

// Render Form Tambah Mahasiswa Admin
function renderCreateStudentForm() {
    appContainer.innerHTML = `
        ${getAdminNavbarHtml()}
        <div class="mt-4">
            <h1>Tambah Mahasiswa Baru</h1>
            <form id="createStudentForm">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                    <div class="invalid-feedback">NIM tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                    <div class="invalid-feedback">Nama tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" class="form-control" id="umur" name="umur" required>
                    <div class="invalid-feedback">Umur tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback">Username tidak boleh kosong.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Password tidak boleh kosong.</div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    `;
    document.getElementById('createStudentForm').addEventListener('submit', handleCreateStudent);
}

// Handle Tambah Mahasiswa
async function handleCreateStudent(e) {
    e.preventDefault();
    const form = e.target;
    if (!validateForm(form)) return;

    const data = {
        nim: form.nim.value,
        nama_lengkap: form.nama_lengkap.value,
        umur: form.umur.value,
        username: form.username.value,
        password: form.password.value,
    };

    await fetch('/api/admin/students/store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });
    renderAdminStudents();
}

// Render Form Edit Mahasiswa Admin
async function renderEditStudentForm(studentId) {
    try {
        const response = await fetch(`/api/admin/students/${studentId}`);
        const student = await response.json();
        
        if (!student.nim) {
            alert('Data mahasiswa tidak ditemukan.');
            renderAdminStudents();
            return;
        }

        appContainer.innerHTML = `
            ${getAdminNavbarHtml()}
            <div class="mt-4">
                <h1>Edit Mahasiswa</h1>
                <form id="editStudentForm" data-student-id="${student.id}">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="${student.nim}" required>
                        <div class="invalid-feedback">NIM tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="${student.nama_lengkap}" required>
                        <div class="invalid-feedback">Nama tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" class="form-control" id="umur" name="umur" value="${student.umur}" required>
                        <div class="invalid-feedback">Umur tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="${student.username}" required>
                        <div class="invalid-feedback">Username tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        `;
        document.getElementById('editStudentForm').addEventListener('submit', handleEditStudent);
    } catch (error) {
        console.error('Failed to fetch student for editing:', error);
    }
}

// Handle Edit Mahasiswa
async function handleEditStudent(e) {
    e.preventDefault();
    const form = e.target;
    if (!validateForm(form)) return;
    
    const studentId = form.dataset.studentId;
    const data = {
        nim: form.nim.value,
        nama_lengkap: form.nama_lengkap.value,
        umur: form.umur.value,
        username: form.username.value,
        password: form.password.value,
    };

    await fetch(`/api/admin/students/update/${studentId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });
    
    renderAdminStudents();
}

// Handle Hapus Mata Kuliah & Mahasiswa
async function confirmDelete(type, id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus ${type} "${name}"?`)) {
        await fetch(`/api/admin/${type}s/delete/${id}`, { method: 'DELETE' });
        if (type === 'course') renderAdminCourses();
        if (type === 'student') renderAdminStudents();
    }
}


// --- Student ---
// Render Dashboard Mahasiswa
function renderStudentDashboard() {
    appContainer.innerHTML = `
        ${getStudentNavbarHtml()}
        <div class="mt-4">
            <h1>Selamat Datang, Mahasiswa!</h1>
            <p class="lead">Ini adalah halaman dashboard mahasiswa.</p>
        </div>
    `;
    updateActiveMenu('Dashboard');
}

// Render Daftar Mata Kuliah Mahasiswa dengan Validasi Checkbox
async function renderStudentCourses() {
    try {
        const [coursesResponse, enrolledCoursesResponse] = await Promise.all([
            fetch('/api/student/courses'),
            fetch('/api/student/enrollments')
        ]);
        const courses = await coursesResponse.json();
        const enrolledCourses = await enrolledCoursesResponse.json();
        
        // Buat objek untuk lookup cepat
        const enrolledCourseIds = new Set(enrolledCourses.map(e => e.course_id));
        
        let courseListHtml = '';
        courses.forEach(course => {
            const isEnrolled = enrolledCourseIds.has(parseInt(course.id));
            const checkedAttr = isEnrolled ? 'checked disabled' : '';

            courseListHtml += `
                <div class="form-check">
                    <input class="form-check-input course-checkbox" type="checkbox" value="${course.id}" data-credits="${course.credits}" id="course-${course.id}" ${checkedAttr}>
                    <label class="form-check-label" for="course-${course.id}">
                        ${course.code} - ${course.name} (${course.credits} SKS)
                        ${isEnrolled ? '<span class="text-success ms-2">✅ Sudah Di-enroll</span>' : ''}
                    </label>
                </div>
            `;
        });

        appContainer.innerHTML = `
            ${getStudentNavbarHtml()}
            <div class="mt-4">
                <h1>Daftar Mata Kuliah</h1>
                <form id="enrollmentForm">
                    <p class="lead">Pilih mata kuliah untuk di-enroll:</p>
                    <div id="courseList">
                        ${courseListHtml}
                    </div>
                    <div class="mt-3 p-3 bg-light rounded">
                        <p class="mb-0">Total SKS terpilih: <strong id="totalCredits">0</strong></p>
                    </div>
                    <button type="submit" class="btn btn-success mt-3" id="submitEnroll">Enroll Mata Kuliah</button>
                </form>
            </div>
        `;
        updateActiveMenu('Daftar Mata Kuliah');
        
        const checkboxes = document.querySelectorAll('.course-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalCredits);
        });

        document.getElementById('enrollmentForm').addEventListener('submit', handleEnroll);
        
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
}

function updateTotalCredits() {
    let total = 0;
    document.querySelectorAll('.course-checkbox:checked').forEach(checkbox => {
        total += parseInt(checkbox.dataset.credits);
    });
    document.getElementById('totalCredits').textContent = total;
}

// Handle Enroll Mata Kuliah
async function handleEnroll(e) {
    e.preventDefault();
    const selectedCourses = [];
    document.querySelectorAll('.course-checkbox:checked').forEach(checkbox => {
        selectedCourses.push(checkbox.value);
    });

    if (selectedCourses.length === 0) {
        alert('Pilih setidaknya satu mata kuliah.');
        return;
    }

    await fetch('/api/student/enroll', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ courses: selectedCourses })
    });
    
    // Perlihatkan contoh async dengan setTimeout
    setTimeout(() => {
        alert('Enrollment berhasil! Data sedang diupdate...');
        renderStudentCourses();
    }, 1000); // Tunggu 1 detik sebelum update UI
}

// Render Daftar Mata Kuliah yang Diambil Mahasiswa
async function renderStudentEnrollments() {
    try {
        const response = await fetch('/api/student/enrollments');
        const enrollments = await response.json();

        let enrollmentListHtml = '';
        if (enrollments.length === 0) {
            enrollmentListHtml = `<tr><td colspan="3" class="text-center">Belum ada mata kuliah yang diambil.</td></tr>`;
        } else {
             // Fetch course details for each enrollment
             const courseIds = enrollments.map(e => e.course_id);
             const courseDetails = {};
             await Promise.all(courseIds.map(async id => {
                 const res = await fetch(`/api/courses/${id}`);
                 const course = await res.json();
                 courseDetails[id] = course;
             }));

             enrollments.forEach(enrollment => {
                const course = courseDetails[enrollment.course_id];
                 if (course) {
                     enrollmentListHtml += `
                         <tr>
                             <td>${course.code}</td>
                             <td>${course.name}</td>
                             <td>${course.credits}</td>
                         </tr>
                     `;
                 }
             });
        }

        appContainer.innerHTML = `
            ${getStudentNavbarHtml()}
            <div class="mt-4">
                <h1>Mata Kuliah yang Diambil</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${enrollmentListHtml}
                    </tbody>
                </table>
            </div>
        `;
        updateActiveMenu('Mata Kuliah Diambil');
    } catch (error) {
        console.error('Failed to fetch enrollments:', error);
    }
}


// Navigasi & Logout
function getAdminNavbarHtml() {
    return `<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderAdminDashboard()">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderAdminCourses()">Manajemen Mata Kuliah</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderAdminStudents()">Manajemen Mahasiswa</a></li>
            </ul>
            <button class="btn btn-danger" onclick="logout()">Logout</button>
        </div>
    </nav>`;
}

function getStudentNavbarHtml() {
    return `<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student Panel</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderStudentDashboard()">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderStudentCourses()">Daftar Mata Kuliah</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="renderStudentEnrollments()">Mata Kuliah Diambil</a></li>
            </ul>
            <button class="btn btn-danger" onclick="logout()">Logout</button>
        </div>
    </nav>`;
}

function updateActiveMenu(menuName) {
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.textContent === menuName) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

function logout() {
    sessionStorage.removeItem('role');
    renderLoginForm();
}

// Initial Render
document.addEventListener('DOMContentLoaded', () => {
    const role = sessionStorage.getItem('role');
    if (role === 'admin') {
        renderAdminDashboard();
    } else if (role === 'student') {
        renderStudentDashboard();
    } else {
        renderLoginForm();
    }
});