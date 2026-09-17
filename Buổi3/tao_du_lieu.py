import random

sql = "USE dulich_tiepcan;\nSET FOREIGN_KEY_CHECKS = 0;\n"
sql += """CREATE TABLE IF NOT EXISTS Service (service_id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255));\n"""
sql += """CREATE TABLE IF NOT EXISTS Accessibility_Info (
    info_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT,
    ramp_slope DECIMAL(4,2),
    door_width DECIMAL(5,2)
);\n"""

for i in range(1, 301):
    sql += f"INSERT INTO Service (name) VALUES ('Dich vu {i}');\n"
    # Random độ dốc từ 5% đến 12%, cửa từ 70cm đến 90cm
    slope = round(random.uniform(5.0, 12.0), 2)
    width = round(random.uniform(70.0, 90.0), 2)
    sql += f"INSERT INTO Accessibility_Info (service_id, ramp_slope, door_width) VALUES ({i}, {slope}, {width});\n"

with open('seed.sql', 'w', encoding='utf-8') as f:
    f.write(sql)
print("Chuc mung! Da tao xong file seed.sql voi 300 ban ghi!")