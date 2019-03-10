import train as t
import emoji
import preprocessor as p
from googletrans import Translator
import re

translator=Translator()

def remove_emoji(string):
    emoji_pattern = re.compile("["
                           u"\U0001F600-\U0001F64F"  # emoticons
                           u"\U0001F300-\U0001F5FF"  # symbols & pictographs
                           u"\U0001F680-\U0001F6FF"  # transport & map symbols
                           u"\U0001F1E0-\U0001F1FF"  # flags (iOS)
                           u"\U00002702-\U000027B0"
                           u"\U000024C2-\U0001F251"
                           "]+", flags=re.UNICODE)
    return emoji_pattern.sub(r'', string)



with open("replies3.txt",'r',encoding='utf-8') as f:
    for line in f:
        try:
            #line=remove_emoji(line)
            line=emoji.demojize(line)
            line=p.clean(line)
            line=translator.translate(line)
            line=line.text
            if(line==''):
                pass
            else:
                sentiment_value,confidence=t.sentiment(line)
                print(line,sentiment_value,confidence,"\n\n\n")
        except:
            pass


























'''import tweepy
from tweepy import Stream
from tweepy import OAuthHandler
from tweepy.streaming import StreamListener
from googletrans import Translator
import re
import json

ckey="gz4VcAW0OaWuheYB3Y6LzLXOc"
csecret="PhzqOWSyZKb38iUmxjDPVZnujqt7YIwVYLRPWnNkjhzlD0TywO"
atoken="1007199770547445762-9NbAVQz4FGGwVfXgs3hig3TfAk6bfM"
asecret="nyqZ9jwBmAnexMEyVyThP14ILIY97cWL8P0u0kir9bCAn"

auth = OAuthHandler(ckey, csecret)
auth.set_access_token(atoken, asecret)
api = tweepy.API(auth)
translator=Translator()

search_tweets = api.search('modi',count=100,tweet_mode='extended')
for tweet in search_tweets:
    
    if 'retweeted_status' in tweet._json:
        tweet=ascii(tweet._json['retweeted_status']['full_text'])
        tweet=translator.translate(tweet)
        tweet=tweet.text
        tweet=p.clean(tweet)
        #tweet = re.sub(r"http\S+", "", tweet)
        sentiment_value,confidence=t.sentiment(tweet)
        print(tweet,sentiment_value,confidence,"\n\n\n")

    else:
        tweet=ascii(tweet.full_text)
        tweet=translator.translate(tweet)
        tweet=tweet.text
        tweet=p.clean(tweet)
        #tweet = re.sub(r"http\S+", "", tweet)
        sentiment_value,confidence=t.sentiment(tweet)
        print(tweet,sentiment_value,confidence,"\n\n\n")     
'''

















'''class listener(StreamListener):

    def on_data(self, data):
        all_data = json.loads(data)
        tweet = all_data["text"]
        #print(ascii(tweet),"\n\n\n")

    def on_error(self, status):
        print(status)

auth = OAuthHandler(ckey, csecret)
auth.set_access_token(atoken, asecret)

twitterStream = Stream(auth, listener())
twitterStream.filter(track=["trump"])'''



'''auth = OAuthHandler(ckey, csecret)
auth.set_access_token(atoken, asecret)
api = tweepy.API(auth)
translator=Translator()

class MyStreamListener(tweepy.StreamListener):

    def on_status(self, status):
        
        translated=translator.translate(ascii(status.text))
        tweet=translated.text
        tweet = re.sub(r"http\S+", "", tweet)
        sentiment_value,confidence=t.sentiment(tweet)
        print(tweet,sentiment_value,confidence,"\n\n\n")
        

myStreamListener = MyStreamListener()
myStream = tweepy.Stream(auth = api.auth, listener=myStreamListener , tweet_mode='extended')

 
myStream.filter(track=['trump'])'''




















