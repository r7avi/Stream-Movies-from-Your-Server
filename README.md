Deploy Application in your Server :

1) Config/db.php ---> Replace credentials with your Database
2) import database.sql to your Database ,  --> https://github.com/r7avi/Stream-Movies-from-Your-Server/blob/main/database.sql
3) Enable FFMpeg for Preview of Thumbnails,
Upload Movies or Series to public/drive folder --> https://github.com/r7avi/Stream-Movies-from-Your-Server/tree/main/public/drive
4) Login logs can be found in https://www.xyz.com/logs.php (which will show users login time)
<br><br>
NOTE : 
Please Upload files in MP4 formate, 
If you upload your files in MKV , then you can convert them using ./convert.sh Bash file in Home directory. (only for VPS users with root permission)
<br><br>
Give them required permissions to bash script to Run :<br><br>
open directory containing convert.sh and delete.sh and run below command <br><br>
sudo chmod +x convert.sh && sudo chmod +x delete.sh<br><br>
--> This command adds execute permissions to the script. After running it, you should be able to execute your script with :
./convert.sh (or) ./delete.sh <br><br>
After converting files from MKV to MP4 run delete.sh to delete MKV files.

sceenshots :
![Screenshot 2024-08-20 172033](https://github.com/user-attachments/assets/9f9fc4b0-a1a7-4e99-9635-853747de1df2)
![Screenshot 2024-08-20 172336](https://github.com/user-attachments/assets/a63bee7d-caf4-43ea-9322-4598f22f135b)
![screencapture-ktmracing-site-public-play-php-2024-08-20-17_24_05](https://github.com/user-attachments/assets/2aeb2ba9-5520-461e-bc5c-94425389c456)

