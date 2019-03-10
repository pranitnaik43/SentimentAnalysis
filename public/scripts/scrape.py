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






'''from urllib.request import urlopen
from bs4 import BeautifulSoup
import preprocessor as p
file = "5_twitterBBC3.csv"
f = open(file, "w")
url = "https://twitter.com/BJP4India/status/1101866088206200832"
html = urlopen(url)
soup = BeautifulSoup(html, "html.parser")
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
        
f.close()'''


from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import train as t
import preprocessor as p
import emoji
from googletrans import Translator


class SeleniumClient(object):
    def __init__(self):

        self.chrome_options = webdriver.ChromeOptions()
        #options.add_argument('headless')
        self.chrome_options.add_argument("--headless") 
        self.chrome_options.add_argument('--blink-settings=imagesEnabled=false')
        self.browser = webdriver.Chrome('C:/webdriver/chromedriver.exe',options=self.chrome_options)

        #self.browser = webdriver.Firefox(executable_path=r'C:\webdriver\geckodriver.exe')

        self.base_url = 'https://twitter.com/search?q='

    def get_tweets(self, query):

        try: 
            self.browser.get(self.base_url+query)

            #self.browser.set_context("chrome")
            body = self.browser.find_element_by_tag_name('body')

            for _ in range(100):
                body.send_keys(Keys.PAGE_DOWN)

            tweets=self.browser.find_elements_by_class_name('tweet-text')

            #self.browser.quit()

            translator=Translator()
            
            for tweet in tweets:
                #print(tweet.text,"\n\n\n")
                tweet=emoji.demojize(tweet.text)
                tweet=p.clean(tweet)
                tweet=translator.translate(tweet)
                tweet=tweet.text
                if(tweet==''):
                    pass
                else:
                    sentiment_value,confidence=t.sentiment(tweet)
                    print(tweet,sentiment_value,confidence,"\n\n\n")
                    #print(tweet)
            self.browser.quit()
            
        except Exception as e: 
            print("Selenium - An error occured while fetching tweets.")
            print(e)

selenium_client = SeleniumClient()

tweets_df = selenium_client.get_tweets('unionbudget2019')
print(tweets_df)









