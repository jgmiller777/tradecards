1,$s~	-	-	Buy Pricing	Buy Pricing	~~gc
1,$s~-	-	Buy Pricing	Buy Pricing	~~gc
1,$s~-	50	Buy Pricing	Buy Pricing~- 50~gc
1,$s~-	100	Buy Pricing	Buy Pricing~- 100~gc
1,$s~25	25	Buy Pricing	Buy Pricing~25 25~gc
1,$s~50	50	Buy Pricing	Buy Pricing~50 50~gc
1,$s~65	65	Buy Pricing	Buy Pricing~65 65~gc
1,$s~99	99	Buy Pricing	Buy Pricing~99 99~gc
1,$s~250	250	Buy Pricing	Buy Pricing~250 250~gc
1,$s~500	500	Buy Pricing	Buy Pricing~500 500~gc
1,$s~2016	2016	Buy Pricing	Buy Pricing~2016 2016~gc
1,$s~-	60000	Buy Pricing	Buy Pricing	~~gc
1,$s~-	80000	Buy Pricing	Buy Pricing	~~gc
1,$s~item image	~~gc
1,$s~ BB~~gc

--->>> run the following two lines multiple times until none are found
--->>> the next line contains a [TAB] character
1,$s~	~~gc
1,$s~ $~~gc

1,$g~^AUSER~d
1,$g~^AURC~d
1,$g~^MEMSER~d
1,$g~^RC~d
1,$g~^AU~d
1,$g~^SER~d
1,$g~^MEM~d
1,$g~- 25~-j
1,$g~- 50~-j
1,$g~- 100~-j
1,$g~25 25~-j
1,$g~50 50~-j
1,$g~65 65~-j
1,$g~99 99~-j
1,$g~250 250~-j
1,$g~500 500~-j
1,$g~2016 2016~-j
1,$g~Team: ~-j
1,$g~^$~d
1,$g~ - 25~s~^\(.*\) \(- 25\)$~\2 \1~
1,$g~ - 50~s~^\(.*\) \(- 50\)$~\2 \1~
1,$g~ - 100~s~^\(.*\) \(- 100\)$~\2 \1~
1,$g~ 25 25~s~^\(.*\) \(25 25\)$~\2 \1~
1,$g~ 50 50~s~^\(.*\) \(50 50\)$~\2 \1~
1,$g~ 65 65~s~^\(.*\) \(65 65\)$~\2 \1~
1,$g~ 99 99~s~^\(.*\) \(99 99\)$~\2 \1~
1,$g~ 250 250~s~^\(.*\) \(250 250\)$~\2 \1~
1,$g~ 500 500~s~^\(.*\) \(500 500\)$~\2 \1~
1,$g~ 2016 2016~s~^\(.*\) \(2016 2016\)$~\2 \1~

--->>> Change hard-coded text in the following as appropriate
1,$s~2016 Donruss #~;Baseball;2016;Panini;Donruss Baseball;Base Cards;%SUBCAT%;#~gc
1,$s~2016 Donruss Optic Red #~;Baseball;2016;Panini;Donruss Optic Baseball;Parallel Cards - Optic Red;%SUBCAT%;#~gc
1,$s~2016 Stadium Club #~;Baseball;2016;Topps;Stadium Club;Base Cards;%SUBCAT%;#~gc
1,$s~2012 Bowman Platinum #~;Baseball;2012;Topps;Bowman Platinum;Base Cards;%SUBCAT%;#~gc
1,$s~1996 Upper Deck #~;Baseball;1996;Upper Deck;Series 1;Base Cards;%SUBCAT%;#~gc
1,$s~2008 SP Authentic Marquee Matchups #~;Baseball;2008;Upper Deck;SP Authenic;Insert Cards;Marquee Matchups;#~gc
1,$s~2016 Bowman #~;Baseball;2016;Bowman;_;Base;%SUBCAT%;#~gc
1,$s~2016 Topps Allen and Ginter #~;Baseball;2016;Allen & Ginter;_;Base;%SUBCAT%;#~gc
1,$s~2015 Topps Gypsy Queen #~;Baseball;2015;Gypsy Queen;_;Base;%SUBCAT%;#~gc
1,$s~2015 Topps Heritage #~;Baseball;2015;Heritage;_;Base;%SUBCAT%;#~gc
1,$s~2016 Topps Amazing Milestones #~;Baseball;2016;Topps;Amazing Milestones;Insert;%SUBCAT%;#~gc
1,$s~1993 Classic Four Sport Power Pick Bonus #~;Multisport;1993;Classic Four Sport;Power Pick Bonus;Insert;%SUBCAT%;#~gc
1,$s~2008 SPx #~;Baseball;2008;SPx;_;Base;%SUBCAT%;#~gc
1,$s~2002 Playoff Piece of the Game Materials #~;Baseball;2002;Playoff;Piece of the Game;Memorabilia;Materials;#~gc
1,$s~2002 Upper Deck Ovation Swatches #~;Baseball;2002;Upper Deck;Ovation;Memorabilia;Swatches;#~gc
1,$s~2002 Upper Deck Ovation Swatches Gold #~;Baseball;2002;Upper Deck;Ovation;Memorabilia - Gold;Swatches;#~gc
1,$s~2016 Topps MLB Debut Medallion #~;Baseball;2016;Topps;Series %X%;Insert;MLB Debut Medallion;#~gc
1,$s~2016 Topps #~;Baseball;2016;Topps;_;Base;%SUBCAT%;#~gc
1,$s~2016 Topps Update #~;Baseball;2016;Topps;Updates;Base;%SUBCAT%;#~gc

1,$s~2016 Topps Gold #~;Baseball;2016;Topps;Series %x%;Parallel - Gold;%SUBCAT%;#~gc
1,$s~2016 Topps Update Gold #~;Baseball;2016;Topps;Updates;Parallel - Gold;%SUBCAT%;#~gc
1,$s~2016 Topps Vintage Stock #~;Baseball;2016;Topps;Series %x%;Parallel - Vintage Stock;%SUBCAT%;#~gc
1,$s~2016 Topps Black #~;Baseball;2016;Topps;Series %x%;Parallel - Black;%SUBCAT%;#~gc
1,$s~2016 Topps Update Black #~;Baseball;2016;Topps;Updates;Parallel - Black;%SUBCAT%;#~gc
1,$s~2016 Topps Pink #~;Baseball;2016;Topps;Series %x%;Parallel - Pink;%SUBCAT%;#~gc
1,$s~2016 Topps Update Pink #~;Baseball;2016;Topps;Updates;Parallel - Pink;%SUBCAT%;#~gc
1,$s~2016 Topps Rainbow Foil #~;Baseball;2016;Topps;Series %x%;Parallel - Rainbow Foil;%SUBCAT%;#~gc
1,$s~2016 Topps Update Rainbow Foil #~;Baseball;2016;Topps;Updates;Parallel - Rainbow Foil;%SUBCAT%;#~gc
1,$s~2016 Topps Toys R Us Purple #~;Baseball;2016;Topps;Series %x%;Parallel - Toys R Us Purple;%SUBCAT%;#~gc

--->>> 4-digit card number with/without subnumber
1,$s~#\([0-9][0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([0-9][0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
1,$s~#\([A-Z][A-Z][0-9][0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([A-Z][A-Z][0-9][0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
1,$s~#\([A-Z][0-9][0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([A-Z][0-9][0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
--->>> 3-digit card number with/without subnumber
1,$s~#\([0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
1,$s~#\([A-Z][A-Z][0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([A-Z][A-Z][0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
1,$s~#\([A-Z][0-9][0-9][0-9]\)\([A-Z]\) \(.*\)~\1;\2;\3~gc
1,$s~#\([A-Z][0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
1,$s~#\(MLBDM[0-9][0-9][0-9]\) \(.*\)~\1; ;\2~gc
--->>> 2-digit card number with/without subnumber
1,$s~#\([0-9][0-9]\)\([A-Z]\) \(.*\)~ \1;\2;\3~gc
1,$s~#\([0-9][0-9]\) \(.*\)~ \1; ;\2~gc
1,$s~#\([A-Z][A-Z][0-9][0-9]\)\([A-Z]\) \(.*\)~ \1;\2;\3~gc
1,$s~#\([A-Z][A-Z][0-9][0-9]\) \(.*\)~ \1; ;\2~gc
1,$s~#\([A-Z][0-9][0-9]\)\([A-Z]\) \(.*\)~ \1;\2;\3~gc
1,$s~#\([A-Z][0-9][0-9]\) \(.*\)~ \1; ;\2~gc
1,$s~#\(MLBDM[0-9][0-9]\) \(.*\)~ \1; ;\2~gc
--->>> 1-digit card number with/without subnumber
1,$s~#\([0-9]\)\([A-Z]\) \(.*\)~  \1;\2;\3~gc
1,$s~#\([0-9]\) \(.*\)~  \1; ;\2~gc
1,$s~#\([A-Z][A-Z][0-9]\)\([A-Z]\) \(.*\)~  \1;\2;\3~gc
1,$s~#\([A-Z][A-Z][0-9]\) \(.*\)~  \1; ;\2~gc
1,$s~#\([A-Z][0-9]\)\([A-Z]\) \(.*\)~  \1;\2;\3~gc
1,$s~#\([A-Z][0-9]\) \(.*\)~  \1; ;\2~gc

1,$s~#\([A-Z][A-Z][A-Z]\) \(.*\)~\1; ;\2~gc
1,$s~#\([M][D][M][A-Z][A-Z]\) \(.*\)~\1; ;\2~gc
1,$s~#\([M][D][M][A-Z][A-Z][A-Z]\) \(.*\)~\1; ;\2~gc

1,$g!~Team:~s~$~|;%PLAYERNAMEEXT%;;%SERIALNBRD%;%AUTOGRAPH%;%RC%;%SP%;%COMM%~gc
1,$s~ Team: \(.*\)~|;%PLAYERNAMEEXT%;\1;%SERIALNBRD%;%AUTOGRAPH%;%RC%;%SP%;%COMM%~gc

1,$g~ S2|~s~%X%~2~gc
1,$g~ S2|~s~ S2|~|~gc
1,$s~%X%~1~gc

1,$g~ AU|~s~%AUTOGRAPH%~Y~gc
1,$g~ AU|~s~ AU|~|~gc

1,$g~ DK|~s~%SUBCAT%~Diamond Kings~gc
1,$g~ DK|~s~ DK|~|~gc

1,$g~ RC|~s~%RC%~Y~gc
1,$g~ RC|~s~ RC|~|~gc
1,$g~ (RC)|~s~%RC%~?~gc
1,$g~ (RC)|~s~%PLAYERNAMEEXT%~(RC)~gc
1,$g~ (RC)|~s~ (RC)|~|~gc
1,$g~ (RC) UER|~s~%RC%~?~gc
1,$g~ (RC) UER|~s~%PLAYERNAMEEXT%~(RC) UER~gc
1,$g~ (RC) UER|~s~ (RC) UER|~|~gc

1,$g~ RR|~s~%SUBCAT%~Rated Rookie~gc
1,$g~ RR|~s~ RR|~|~gc

1,$g~ YH|~s~%SUBCAT%~Young at Heart~gc
1,$g~ YH|~s~ YH|~|~gc

1,$g~ AS|~s~%SUBCAT%~All-Star Game~gc
1,$g~ AS|~s~ AS|~|~gc

1,$g~ BO|~s~%SUBCAT%~Beat the Odds~gc
1,$g~ BO|~s~ BO|~|~gc

1,$g~ FS|~s~%SUBCAT%~Future Stars~gc
1,$g~ FS|~s~ FS|~|~gc

1,$g~ PCL|~s~%SUBCAT%~Postseason Checklist~gc
1,$g~ PCL|~s~ PCL|~|~gc

1,$g~ MCL|~s~%SUBCAT%~Managerial Salute Checklist~gc
1,$g~ MCL|~s~ MCL|~|~gc

1,$g~ BG|~s~%SUBCAT%~Best of a Generation~gc
1,$g~ BG|~s~ BG|~|~gc

1,$g~ MG|~s~%SUBCAT%~Managers~gc
1,$g~ MG|~s~ MG|~|~gc

1,$g~ ML|~s~%SUBCAT%~Milestones~gc
1,$g~ ML|~s~ ML|~|~gc

1,$g~ SBT|~s~%SUBCAT%~Strange but True~gc
1,$g~ SBT|~s~ SBT|~|~gc

1,$g~ WSH|~s~%SUBCAT%~World Series Highlights~gc
1,$g~ WSH|~s~ WSH|~|~gc

1,$g~ Rookie Combos|~s~%SUBCAT%~Rookie Combos~gc
1,$g~ Rookie Combos|~s~ Rookie Combos|~|~gc

1,$g~ RD|~s~%SUBCAT%~Rookie Debut~gc
1,$g~ RD|~s~ RD|~|~gc

1,$g~ HL|~s~%SUBCAT%~Highlights~gc
1,$g~ HL|~s~ HL|~|~gc

1,$g~; 26;.* LL|~s~%SUBCAT%~Home Run Leaders~gc
1,$g~; 29;.* LL|~s~%SUBCAT%~Batting Average Leaders~gc
1,$g~; 58;.* LL|~s~%SUBCAT%~ERA Leaders~gc
1,$g~;125;.* LL|~s~%SUBCAT%~WHIP Leaders~gc
1,$g~;162;.* LL|~s~%SUBCAT%~RBI Leaders~gc
1,$g~;166;.* LL|~s~%SUBCAT%~RBI Leaders~gc
1,$g~;185;.* LL|~s~%SUBCAT%~ERA Leaders~gc
1,$g~;187;.* LL|~s~%SUBCAT%~Wins Leaders~gc
1,$g~;220;.* LL|~s~%SUBCAT%~Wins Leaders~gc
1,$g~;337;.* LL|~s~%SUBCAT%~Home Run Leaders~gc
1,$g~;338;.* LL|~s~%SUBCAT%~Batting Average Leaders~gc
1,$g~;346;.* LL|~s~%SUBCAT%~WHIP Leaders~gc
1,$g~ LL|~s~ LL|~|~gc

1,$g~ HRD|~s~%SUBCAT%~Home Run Derby~gc
1,$g~ HRD|~s~ HRD|~|~gc

1,$s~/50~~gc
1,$s~/100~~gc

1,$g~ 2131|~s~%PLAYERNAMEEXT%~2131~gc
1,$g~ 2131|~s~ 2131|~|~gc

1,$g~ 3000 Hits|~s~%PLAYERNAMEEXT%~3000 Hits~gc
1,$g~ 3000 Hits|~s~ 3000 Hits|~|~gc

1,$g~ UER|~s~%PLAYERNAMEEXT%~UER~gc
1,$g~ UER|~s~ UER|~|~gc

1,$g~ Bat-Jsy|~s~%PLAYERNAMEEXT%~Bat-Jsy~gc
1,$g~ Bat-Jsy|~s~ Bat-Jsy|~|~gc

1,$g~ Blue Jsy|~s~%PLAYERNAMEEXT%~Blue Jsy~gc
1,$g~ Blue Jsy|~s~ Blue Jsy|~|~gc

1,$g~ White Jsy|~s~%PLAYERNAMEEXT%~White Jsy~gc
1,$g~ White Jsy|~s~ White Jsy|~|~gc

1,$g~ Grey Jsy|~s~%PLAYERNAMEEXT%~Grey Jsy~gc
1,$g~ Grey Jsy|~s~ Grey Jsy|~|~gc

1,$g~ Jsy|~s~%PLAYERNAMEEXT%~Jsy~gc
1,$g~ Jsy|~s~ Jsy|~|~gc

1,$g~ Bat|~s~%PLAYERNAMEEXT%~Bat~gc
1,$g~ Bat|~s~ Bat|~|~gc

1,$g~ Btg Glv|~s~%PLAYERNAMEEXT%~Btg Glv~gc
1,$g~ Btg Glv|~s~ Btg Glv|~|~gc

1,$g~ Fld Glv|~s~%PLAYERNAMEEXT%~Fld Glv~gc
1,$g~ Fld Glv|~s~ Fld Glv|~|~gc

1,$g~ Base|~s~%PLAYERNAMEEXT%~Base~gc
1,$g~ Base|~s~ Base|~|~gc

1,$g~ Ball|~s~%PLAYERNAMEEXT%~Ball~gc
1,$g~ Ball|~s~ Ball|~|~gc

1,$g~ Hat|~s~%PLAYERNAMEEXT%~Hat~gc
1,$g~ Hat|~s~ Hat|~|~gc

1,$g~ Chest Pro|~s~%PLAYERNAMEEXT%~Chest Pro~gc
1,$g~ Chest Pro|~s~ Chest Pro|~|~gc

1,$g~ Wristband|~s~%PLAYERNAMEEXT%~Wristband~gc
1,$g~ Wristband|~s~ Wristband|~|~gc

1,$g~ Pants|~s~%PLAYERNAMEEXT%~Pants~gc
1,$g~ Pants|~s~ Pants|~|~gc

1,$g~ Shoe|~s~%PLAYERNAMEEXT%~Shoe~gc
1,$g~ Shoe|~s~ Shoe|~|~gc

// old line --- 1,$g~ SP.*|~s~ \(SP.*\)\(|;\)\(.*\)$~\2\3;@@\1~gc
1,$g~ SP/.*|~s~ SP/\(.*\)\(|;\)\(.*\)%SP%\(.*\)$~\2\3\1\4~gc
1,$g~ VAR/.*|~s~ \(VAR/.*\)\(|;\)\(.*\)%SP%\(.*\)$~\2\3\1\4~gc
1,$g~ SP|~s~%SP%~Y~gc
1,$g~ SP|~s~ SP|~|~gc

1,$g~- 25 ~s~- 25 \(.*\)%SP%\(.*\)~\1Y\2~
1,$g~- 50 ~s~- 50 \(.*\)%SP%\(.*\)~\1Y\2~
1,$g~- 100 ~s~- 100 \(.*\)%SP%\(.*\)~\1Y\2~
1,$g~25 25 ~s~25 25 \(.*\)%SERIALNBRD%\(.*\)~\125\2~
1,$g~50 50 ~s~50 50 \(.*\)%SERIALNBRD%\(.*\)~\150\2~
1,$g~65 65 ~s~65 65 \(.*\)%SERIALNBRD%\(.*\)~\165\2~
1,$g~99 99 ~s~99 99 \(.*\)%SERIALNBRD%\(.*\)~\199\2~
1,$g~250 250 ~s~250 250 \(.*\)%SERIALNBRD%\(.*\)~\1250\2~
1,$g~500 500 ~s~500 500 \(.*\)%SERIALNBRD%\(.*\)~\1500\2~
1,$g~2016 2016 ~s~2016 2016 \(.*\)%SERIALNBRD%\(.*\)~\12016\2~

1,$s~Tony Gwynn~Tony Gwynn Sr.~gc
1,$s~C.C. Sabathia~CC Sabathia~gc
1,$s~Miguel Gonzalez~Miguel Alfredo Gonzalez~gc
1,$s~Miguel Gonzalez~Miguel Angel Gonzalez~gc
1,$s~Luis Perdomo~Luis D. Perdomo~gc
1,$s~Luis Perdomo~Luis M. Perdomo~gc
1,$s~Lance McCullers~Lance McCullers Jr.~gc
1,$s~Lance McCullers~Lance McCullers Sr.~gc
1,$s~Jose Ramirez~Jose Altagracia Ramirez~gc
1,$s~Jose Ramirez~Jose Enrique Ramirez~gc
1,$s~Chris Young~Chris B. Young~gc
1,$s~Chris Young~Chris R. Young~gc
1,$s~Edwin Diaz~Edwin O. Diaz~gc
1,$s~Jon Niese~Jonathon Niese~gc
1,$s~Michael Morse~Mike Morse~gc
1,$s~Nori Aoki~Norichika Aoki~gc
1,$s~Wellington Castillo~Welington Castillo~gc

1,$s~%SUBCAT%~~g
1,$s~%PLAYERNAMEEXT%~~g
1,$s~%SERIALNBRD%~~g
1,$s~%AUTOGRAPH%~N~g
1,$s~%RC%~~g
1,$s~%SP%~~g
1,$s~%COMM%~~g
1,$s~ |~|~gc
1,$s~|~~gc
