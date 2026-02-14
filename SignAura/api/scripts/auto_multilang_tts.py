from gtts import gTTS
from playsound import playsound
import os
import time

def auto_speak(text, language):
    """
    language:
    'en' = English
    'si' = Sinhala
    'ta' = Tamil
    """
    if text is None or text.strip() == "":
        return

    tts = gTTS(text=text, lang=language)
    filename = "voice_output.mp3"
    tts.save(filename)
    playsound(filename)
    os.remove(filename)

# ===============================
# AUTOMATIC TEXT INPUT SIMULATION
# ===============================

while True:
    print("\nSelect language:")
    print("1 - English")
    print("2 - Sinhala")
    print("3 - Tamil")
    print("0 - Exit")

    choice = input("Enter choice: ")

    if choice == "0":
        break

    text = input("Enter text: ")

    if choice == "1":
        auto_speak(text, "en")
    elif choice == "2":
        auto_speak(text, "si")
    elif choice == "3":
        auto_speak(text, "ta")

    time.sleep(0.3)
