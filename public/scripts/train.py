##import sys
##sys.path.append('C:\\Users\\Pranit\\AppData\\Local\\Programs\\Python\\Python37\\Lib\\site-packages')
###sys.path.append('C:\Users\Pranit\AppData\Local\Programs\Python\Python37\Lib\site-packages')
##sys.path.append('C:\\Users\\Pranit\\AppData\\Roaming')
###sys.path.append('C:\Users\Pranit\AppData\Roaming')
import os
os.environ.__setitem__('APPDATA','C:\\Users\\Pranit\\AppData\\Local\\Programs\\Python\\Python37\\Lib\\site-packages')
os.environ.__setitem__('APPDATA','C:\\Users\\Pranit\\AppData\\Roaming')

import nltk
import random
import pickle
from nltk.classify.scikitlearn import SklearnClassifier
from sklearn.naive_bayes import MultinomialNB
# , BernoulliNB
#from sklearn.linear_model import LogisticRegression
#from sklearn.svm import SVC,LinearSVC,NuSVC
from nltk.classify import ClassifierI
from statistics import mode
from nltk.tokenize import word_tokenize
from nltk.tokenize import PunktSentenceTokenizer

class VoteClassifier(ClassifierI):
    
    def __init__(self,*classifiers):
        self._classifiers=classifiers

    def classify(self,features):
        votes = []
        for c in self._classifiers:
            v = c.classify(features)
            votes.append(v)
        return mode(votes)

    def confidence(self, features):
        votes = []
        for c in self._classifiers:
            v = c.classify(features)
            votes.append(v)

        choice_votes = votes.count(mode(votes))
        conf = choice_votes / len(votes)
        return conf

'''positive=open("positive.txt","r").read()
negative=open("negative.txt","r").read()

all_words=[]
documents=[]
allowed_word_types=["J"]

for p in positive.split('\n'):
    documents.append((p,"pos"))
    words=word_tokenize(p)
    pos=nltk.pos_tag(words)
    for w in pos:
        if w[1][0] in allowed_word_types:
            all_words.append(w[0].lower())

for n in negative.split('\n'):
    documents.append((n,"neg"))
    words=word_tokenize(n)
    pos=nltk.pos_tag(words)
    for w in pos:
        if w[1][0] in allowed_word_types:
            all_words.append(w[0].lower())

save_documents=open("documents.pickle","wb")
pickle.dump(documents,save_documents)
save_documents.close()

all_words=nltk.FreqDist(all_words)
word_features=list(all_words.keys())[:5000]

save_word_features=open("wordfeatures.pickle","wb")
pickle.dump(word_features,save_word_features)
save_word_features.close()
'''

##abspath = pathlib.Path("scripts\documents.pickle").absolute()
##with open(str(abspath), 'wb') as f:

##documents_pickle=open(abspath,"rb")
documents_pickle=open("scripts\\documents.pickle","rb")
documents=pickle.load(documents_pickle)
documents_pickle.close()

word_features_pickle=open("scripts\\wordfeatures.pickle","rb")
word_features=pickle.load(word_features_pickle)
word_features_pickle.close()

def find_features(doc):
    tokenized=word_tokenize(doc)
    features={}
    for w in word_features:
        features[w]=(w in tokenized)
    #print(features)
    return features

'''featuresets=[(find_features(rev),category) for (rev,category) in documents]

save_featuresets=open("featuresets.pickle","wb")
pickle.dump(featuresets,save_featuresets)
save_featuresets.close()'''

feature_sets_pickle=open("scripts\\featuresets.pickle","rb")
featuresets=pickle.load(feature_sets_pickle)
feature_sets_pickle.close()

random.shuffle(featuresets)
#print(featuresets)

training_set=featuresets[:3000]
testing_set=featuresets[3000:4000]

#1
'''classifier=nltk.NaiveBayesClassifier.train(training_set)
print("NaiveBayes_classifier accuracy percent:", (nltk.classify.accuracy(classifier,testing_set)*100))
classifier.show_most_informative_features(15)

save_classifier=open("NaiveBayesClassifier.pickle","wb")
pickle.dump(classifier,save_classifier)
save_classifier.close()'''

'''NaiveBayesClassifier_pickle=open("scripts\\NaiveBayesClassifier.pickle","rb")
classifier=pickle.load(NaiveBayesClassifier_pickle)
NaiveBayesClassifier_pickle.close()'''

#2
'''MNB_classifier=SklearnClassifier(MultinomialNB())
MNB_classifier.train(training_set)
print("MNB_classifier accuracy percent:", (nltk.classify.accuracy(MNB_classifier,testing_set)*100))

save_MNB_classifier=open("MNBClassifier.pickle","wb")
pickle.dump(MNB_classifier,save_MNB_classifier)
save_MNB_classifier.close()'''

MNBClassifier_pickle=open("scripts\\MNBClassifier.pickle","rb")
MNB_classifier=pickle.load(MNBClassifier_pickle)
MNBClassifier_pickle.close()

#3
'''BernoulliNB_classifier=SklearnClassifier(BernoulliNB())
BernoulliNB_classifier.train(training_set)
print("BernoulliNB_classifier accuracy percent:", (nltk.classify.accuracy(BernoulliNB_classifier,testing_set)*100))

save_BernoulliNB_classifier=open("BernoulliNBClassifier.pickle","wb")
pickle.dump(BernoulliNB_classifier,save_BernoulliNB_classifier)
save_BernoulliNB_classifier.close()'''

'''BernoulliNB_pickle=open("scripts\\BernoulliNBClassifier.pickle","rb")
BernoulliNB_classifier=pickle.load(BernoulliNB_pickle)
BernoulliNB_pickle.close()'''

#4
'''LogisticRegression_classifier = SklearnClassifier(LogisticRegression(solver='lbfgs'))
LogisticRegression_classifier.train(training_set)
print("LogisticRegression_classifier accuracy percent:", (nltk.classify.accuracy(LogisticRegression_classifier, testing_set)*100))

save_LogisticRegression_classifier = open("LogisticRegression.pickle","wb")
pickle.dump(LogisticRegression_classifier, save_LogisticRegression_classifier)
save_LogisticRegression_classifier.close()'''

'''LogisticRegression_pickle=open("scripts\\LogisticRegression.pickle","rb")
LogisticRegression_classifier=pickle.load(LogisticRegression_pickle)
LogisticRegression_pickle.close()'''

#5
'''LinearSVC_classifier = SklearnClassifier(LinearSVC())
LinearSVC_classifier.train(training_set)
print("LinearSVC_classifier accuracy percent:", (nltk.classify.accuracy(LinearSVC_classifier, testing_set))*100)

save_LinearSVC_classifier = open("LinearSVC.pickle","wb")
pickle.dump(LinearSVC_classifier, save_LinearSVC_classifier)
save_LinearSVC_classifier.close()'''

'''LinearSVC_pickle=open("scripts\\LinearSVC.pickle","rb")
LinearSVC_classifier=pickle.load(LinearSVC_pickle)
LinearSVC_pickle.close()'''

'''#6
SGDC_classifier = SklearnClassifier(SGDClassifier())
SGDC_classifier.train(training_set)
print("SGDClassifier accuracy percent:", (nltk.classify.accuracy(SGDC_classifier, testing_set)*100))

save_SGDC_classifier = open("SGDCclassifier.pickle","wb")
pickle.dump(SGDC_classifier, save_SGDC_classifier)
save_SGDC_classifier.close()'''

#7
'''NuSVC_classifier = SklearnClassifier(NuSVC())
NuSVC_classifier.train(training_set)
print("NuSVC_classifier accuracy percent:", (nltk.classify.accuracy(NuSVC_classifier, testing_set))*100)

save_NuSVC_classifier = open("NuSVC.pickle","wb")
pickle.dump(NuSVC_classifier, save_NuSVC_classifier)
save_NuSVC_classifier.close()'''

'''NuSVC_pickle=open("scripts\\NuSVC.pickle","rb")
NuSVC_classifier=pickle.load(NuSVC_pickle)
NuSVC_pickle.close()'''

'''voted_classifier = VoteClassifier(
                                  classifier,
                                  LinearSVC_classifier,
                                  MNB_classifier,
                                  BernoulliNB_classifier,
                                  LogisticRegression_classifier)'''


voted_classifier=VoteClassifier(MNB_classifier)

#print("voted_classifier accuracy percent:", (nltk.classify.accuracy(voted_classifier, testing_set))*100)

def sentiment(text):
    feats = find_features(text)
    return voted_classifier.classify(feats),voted_classifier.confidence(feats)

#print(sentiment("overall budget is good"))



































