import shutil
import os

folder_name = "Adib_BackendAssessment"
zip_name = "Adib_BackendAssessment"

shutil.make_archive(zip_name, 'zip', folder_name)
print(f"Created {zip_name}.zip")
