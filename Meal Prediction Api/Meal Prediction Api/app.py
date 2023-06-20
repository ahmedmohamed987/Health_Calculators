import io
# import string
# import time
# import os
import numpy as np
import tensorflow as tf
from PIL import Image
from flask import Flask, jsonify, request 
import pickle
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

model = tf.keras.models.load_model('FinaalVersionOfModel.h5')
classes = np.loadtxt('labels.txt',delimiter=',',dtype=str)
# model = pickle.load(open('Finaal-Meal-Prediction-Model.pkl', 'rb'))
# model = load_model('FinaalVersionOfModel.h5')


def ImagePreprocessing(img):
    img = Image.open(io.BytesIO(img))
    img = img.resize((224, 224))
    img = np.array(img)
    img = np.expand_dims(img, 0)
    return img


def PredictMeal(img):
    prediction = model.predict(img)
    index = np.argmax(prediction)
    meal_name = str(classes[index])
    return meal_name


@app.route('/predict', methods=['POST'])
def PredictMealName():

    if 'file' not in request.files:
        return "Please try again. The Image doesn't exist"
    
    file = request.files.get('file')

    # print(file)
    if not file:
        return
    meal_image = file.read()
    img = ImagePreprocessing(meal_image)
    # return jsonify(PredictMeal(img))
    return jsonify(MealName = PredictMeal(img))


if __name__ == '__main__':
    app.run(debug=True)