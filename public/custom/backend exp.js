function showContactUsForm() {
    Swal.fire({
        title: 'Contact Us',
        icon: 'info',
        html: `
            <form class="space-y-4 " method="post" enctype="multipart/form-data">
                <div class="flex flex-col space-y-2">
                    <label class="block text-left text-gray-700 font-medium" for="fullname">Full Name</label>
                    <input class="form-input mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" placeholder="Full Name" name="fullname" autocomplete="off" required>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="block text-left text-gray-700 font-medium" for="contactnum">Contact Number</label>
                    <input class="form-input mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" placeholder="Contact Number" name="contactnum" maxlength="11" autocomplete="off">
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="block text-left text-gray-700 font-medium" for="email">Email</label>
                    <input class="form-input mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" placeholder="your valid email address" name="email" autocomplete="off" required>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="block text-left text-gray-700 font-medium" for="email">Email</label>
                    <input class="form-input mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" placeholder="Subject" name="subject" autocomplete="off" required>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="block text-left text-gray-700 font-medium" for="concern">Concern</label>
                    <textarea class="form-input mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" placeholder="State your Concern..." name="concern" autocomplete="off" required></textarea>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button class="btn btn-outline-success py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-600" type="submit" name="submitConcern">Save</button>
                    <button class="btn btn-secondary py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600" type="button" onclick="Swal.close();">Cancel</button>
                </div>
            </form>
        `,
        showConfirmButton: false,
    });
}

function showForm() {
    Swal.fire({
        title: 'Custom Alert',
        text: 'This is a custom message.',
        icon: 'info',
        confirmButtonText: 'Okay'
        
    });
    
}