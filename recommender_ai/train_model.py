import mysql.connector
import pandas as pd
from surprise import Dataset, Reader, SVD
import joblib

# 1. Kết nối tới MySQL
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="your_password",  # Thay bằng mật khẩu của bạn
    database="sachtruyen"
)



# 2. Lấy dữ liệu từ bảng favorites
query = "SELECT user_id, book_id FROM favorites"
df = pd.read_sql(query, conn)

# 3. Gán điểm đánh giá mặc định (vì người thích thì coi như đánh giá 5 sao)
df['rating'] = 5.0

# 4. Chuẩn hóa dữ liệu cho mô hình
reader = Reader(rating_scale=(1, 5))
data = Dataset.load_from_df(df[['user_id', 'book_id', 'rating']], reader)
trainset = data.build_full_trainset()

# 5. Huấn luyện mô hình
model = SVD()
model.fit(trainset)

# 6. Lưu mô hình đã huấn luyện ra file
joblib.dump(model, 'recommender_model.pkl')
print("✅ Mô hình đã được huấn luyện và lưu vào recommender_model.pkl")
