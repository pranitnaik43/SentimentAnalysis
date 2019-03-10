'''from urllib.request import urlopen
from bs4 import BeautifulSoup

#file = "5_twitterBBC.csv"
#f = open(file, "w")
#Headers = "tweet_user, tweet_text,  replies,  retweets\n"
#f.write(Headers)
for page in range(0,1):
    url = "https://twitter.com/BBCSport/status/1102146597805121536".format(page)
    html = urlopen(url)
    soup = BeautifulSoup(html,"html.parser")
    tweets = soup.find_all("div", {"class":"js-stream-item"})
    for tweet in tweets:
        try:
            if tweet.find('p',{"class":'tweet-text'}):
             tweet_user = tweet.find('span',{"class":'username'}).text.strip()
             tweet_text = tweet.find('p',{"class":'tweet-text'}).text.encode('utf8').strip()
             replies = tweet.find('span',{"class":"ProfileTweet-actionCount"}).text.strip()
             retweets = tweet.find('span', {"class" : "ProfileTweet-action--retweet"}).text.strip()
             print(tweet_user, tweet_text,  replies,  retweets)
             f.write("{}".format(tweet_user).replace(",","|")+ ",{}".format(tweet_text)+ ",{}".format( replies).replace(",", " ")+ ",{}".format(retweets) +  "\n")
        except: AttributeError
#f.close()'''






from urllib.request import urlopen
from bs4 import BeautifulSoup
import preprocessor as p
file = "5_twitterBBC3.csv"
f = open(file, "w")
# url = "https://twitter.com/BJP4India/status/1101866088206200832"
url = "https://twitter.com/search?q=unionbudget2019"

html = urlopen(url)
soup = BeautifulSoup(html, "html.parser")
for page in range(0,3):
    # Gets the tweet
    tweets = soup.find_all("li", attrs={"class":"js-stream-item"})

    # Writes tweet fetched in file
    for tweet in tweets:
        if tweet.find('p',{"class":'tweet-text'}):
            tweet_user = tweet.find('span',{"class":'username'}).text.strip()
            tweet_text = tweet.find('p',{"class":'tweet-text'}).text.encode('utf8').strip()
            replies = tweet.find('span',{"class":"ProfileTweet-actionCount"}).text.strip()
            retweets = tweet.find('span', {"class" : "ProfileTweet-action--retweet"}).text.strip()
            # String interpolation technique
            #f.write(f'{tweet_user},{tweet_text},{replies},{retweets}\n')
            reply=p.clean(str(tweet_text))
            reply=reply[1:]
            print(reply)
            f.write(f'{tweet_text}\n')
        
f.close()










