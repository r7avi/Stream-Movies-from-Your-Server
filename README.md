## Deploy Application on Your Server

1. **Configure Database:**
   - Edit `Config/db.php` and replace the placeholders with your database credentials.

2. **Import Database:**
   - Import the `database.sql` file into your database. You can find the file [here](https://github.com/r7avi/Stream-Movies-from-Your-Server/blob/main/database.sql).

3. **Enable FFMpeg for Thumbnail Preview:**
   - Ensure FFMpeg is enabled for generating previews of thumbnails.

4. **Upload Movies or Series:**
   - Upload your movies or series to the `public/drive` folder. You can find this folder [here](https://github.com/r7avi/Stream-Movies-from-Your-Server/tree/main/public/drive).

5. **Access Login Logs:**
   - Login logs can be viewed at [https://www.xyz.com/logs.php](https://www.xyz.com/logs.php), which will display user login times.

---

### NOTE:

- Please upload files in MP4 format.
- If you upload files in MKV format, you can convert them using the `convert.sh` bash script located in the home directory. This step is only applicable for VPS users with root permissions.

---

### Set Permissions for Bash Scripts

To give the required permissions to the bash scripts, follow these steps:

1. Open the directory containing `convert.sh` and `delete.sh`.
2. Run the following command:

    ```bash
    sudo chmod +x convert.sh && sudo chmod +x delete.sh
    ```

   This command adds execute permissions to the scripts.

3. After running the command, you can execute the scripts with:

    ```bash
    ./convert.sh
    ```

    or

    ```bash
    ./delete.sh
    ```

4. After converting files from MKV to MP4, run `delete.sh` to remove the MKV files.



sceenshots :
![Screenshot 2024-08-20 172033](https://github.com/user-attachments/assets/9f9fc4b0-a1a7-4e99-9635-853747de1df2)
![Screenshot 2024-08-20 172336](https://github.com/user-attachments/assets/a63bee7d-caf4-43ea-9322-4598f22f135b)
![screencapture-ktmracing-site-public-play-php-2024-08-20-17_24_05](https://github.com/user-attachments/assets/2aeb2ba9-5520-461e-bc5c-94425389c456)

