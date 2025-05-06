from fastapi import FastAPI
import joblib
import pandas as pd
import mysql.connector

app = FastAPI()
model = joblib.load("recommender_model.pkl")

# Lấy danh sách sách (để lọc gợi ý)
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="your_password",
    database="sachtruyen"
)
books_df = pd.read_sql("SELECT id FROM books", conn)

@app.get("/recommend/{user_id}")
def recommend(user_id: int):
    # Gợi ý 5 sách chưa đọc
    predictions = []
    for book_id in books_df['id']:
        pred = model.predict(user_id, book_id)
        predictions.append((book_id, pred.est))

    top_books = sorted(predictions, key=lambda x: x[1], reverse=True)[:5]
    return {"recommended_books": [b[0] for b in top_books]}
