-- Tables
CREATE TABLE `categories` (
  `category_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `recipes` (
  `recipe_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `prep_time_minutes` INT,
  `cook_time_minutes` INT,
  `servings` INT,
  `calories_per_serving` INT,
  `protein_g` INT,
  `carbs_g` INT,
  `fat_g` INT,
  `ingredients` TEXT NOT NULL,
  `instructions` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `recipe_categories` (
  `recipe_id` INT,
  `category_id` INT,
  PRIMARY KEY (`recipe_id`, `category_id`),
  FOREIGN KEY (`recipe_id`) REFERENCES `recipes`(`recipe_id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data insertion
INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner'),
(4, 'Snack'),
(5, 'Dessert');

INSERT INTO `recipes` (`recipe_id`, `title`, `prep_time_minutes`, `cook_time_minutes`, `servings`, `calories_per_serving`, `protein_g`, `carbs_g`, `fat_g`, `ingredients`, `instructions`) VALUES
(1, 'Classic Avocado Toast', 5, 5, 1, 290, 7, 30, 17, '- 2 slices sourdough bread\n- 1 ripe avocado\n- 1 tbsp lemon juice\n- 1/4 tsp red pepper flakes\n- Salt and black pepper to taste', '1. Toast sourdough slices to desired crispness.\n2. In a small bowl, mash ripe avocado with lemon juice, salt, and black pepper.\n3. Spread mashed avocado mixture evenly over warm toast.\n4. Top with red pepper flakes and serve immediately.'),
(2, 'Fluffy Oatmeal Pancakes', 10, 10, 2, 280, 10, 45, 7, '- 1 cup rolled oats\n- 1 banana\n- 1/2 cup milk\n- 1 egg\n- 1 tsp baking powder', '1. Add oats, banana, milk, egg, and baking powder into a blender.\n2. Blend on high until completely smooth, about 30–45 seconds.\n3. Heat a non-stick skillet over medium-low heat and lightly grease with oil or butter.\n4. Pour 1/4 cup portions of batter onto the hot pan.\n5. Cook until small bubbles form on top, flip, and cook until golden brown.'),
(3, 'Greek Yogurt Berry Bowl', 5, 0, 1, 240, 18, 32, 4, '- 1 cup Greek yogurt\n- 1/2 cup mixed berries\n- 2 tbsp granola\n- 1 tbsp honey', '1. Scoop Greek yogurt into a clean serving bowl.\n2. Arrange fresh berries over one half of the yogurt.\n3. Add granola over the other half for texture.\n4. Drizzle with honey right before serving.'),
(4, 'Mediterranean Quinoa Salad', 15, 15, 4, 310, 9, 38, 14, '- 1 cup quinoa\n- 1/2 cup cucumber, chopped\n- 1/2 cup cherry tomatoes, halved\n- 1/4 cup feta cheese, crumbled\n- 2 tbsp olive oil\n- 1 tbsp lemon juice', '1. Rinse 1 cup quinoa under cold water, then cook in 2 cups water for 15 minutes or until tender.\n2. Fluff cooked quinoa with a fork and let cool slightly.\n3. Chop cucumber and cherry tomatoes into bite-sized pieces.\n4. In a large bowl, combine quinoa, chopped vegetables, and crumbled feta.\n5. Drizzle with olive oil and lemon juice, then toss well to mix.'),
(5, 'Grilled Chicken Caesar Wrap', 10, 10, 2, 450, 32, 35, 20, '- 2 large tortillas\n- 1 cup grilled chicken breast, diced\n- 1 cup romaine lettuce, chopped\n- 2 tbsp Caesar dressing\n- 2 tbsp Parmesan cheese, grated', '1. Dice or slice cooked grilled chicken breasts.\n2. Toss chicken, chopped romaine lettuce, Caesar dressing, and Parmesan in a mixing bowl.\n3. Lay tortillas flat on a clean surface.\n4. Place half of chicken mixture in the center of each tortilla.\n5. Fold sides in and roll tightly from bottom to top.'),
(6, 'Caprese Sandwich', 10, 0, 1, 410, 16, 42, 19, '- 1 ciabatta roll\n- 3 slices fresh mozzarella\n- 1 tomato, sliced\n- 4 fresh basil leaves\n- 1 tbsp balsamic glaze', '1. Slice ciabatta roll in half lengthwise.\n2. Layer mozzarella slices, fresh tomato slices, and basil leaves on bottom piece.\n3. Drizzle balsamic glaze evenly over toppings.\n4. Place top bun on sandwich, slice in half, and serve.'),
(7, 'Chicken Fried Rice', 10, 15, 3, 380, 22, 48, 11, '- 2 cups chilled cooked rice\n- 1 cup cooked chicken, diced\n- 1/2 cup peas and carrots\n- 2 eggs\n- 2 tbsp soy sauce', '1. Heat skillet over medium, crack eggs inside, and scramble until cooked; set aside.\n2. Add oil to skillet, stir-fry peas, carrots, and diced chicken until warm.\n3. Add chilled cooked rice, breaking up lumps with a spatula.\n4. Pour soy sauce over rice and toss continuously until heated through.\n5. Fold scrambled eggs back into rice and serve hot.'),
(8, 'Creamy Tomato Basil Soup', 10, 25, 4, 210, 4, 20, 13, '- 1 can (28 oz) crushed tomatoes\n- 2 cups vegetable broth\n- 1/2 cup heavy cream\n- 1/4 cup fresh basil, chopped\n- 1 yellow onion, diced\n- 2 garlic cloves, minced', '1. Heat olive oil in a pot over medium, add diced onion and minced garlic, sauté 3-5 mins.\n2. Pour in crushed tomatoes and vegetable broth; bring to a simmer.\n3. Simmer uncovered for 15 minutes to blend flavors.\n4. Blend soup using an immersion blender until smooth.\n5. Stir in heavy cream and chopped fresh basil leaves, then warm through.'),
(9, 'Grilled Cheese Sandwich', 5, 8, 1, 420, 14, 30, 27, '- 2 slices bread\n- 2 slices cheddar cheese\n- 1 tbsp butter, softened', '1. Spread butter evenly on one side of each bread slice.\n2. Place one slice butter-side down in a non-stick pan over medium-low heat.\n3. Lay cheddar cheese slices on top of bread.\n4. Cover with second bread slice, butter-side facing up.\n5. Toast 3-4 mins per side until golden brown and cheese is fully melted.'),
(10, 'Classic Beef Tacos', 10, 15, 4, 360, 20, 24, 20, '- 1 lb ground beef\n- 1 packet taco seasoning\n- 8 hard taco shells\n- 1/2 cup lettuce, shredded\n- 1/2 cup cheddar cheese, shredded', '1. Heat skillet over medium-high heat, add ground beef, cook until browned, then drain excess fat.\n2. Stir in taco seasoning packet and recommended amount of water.\n3. Simmer over medium-low heat for 5 minutes until sauce thickens.\n4. Warm taco shells according to package instructions.\n5. Spoon beef into taco shells and top with shredded lettuce and cheddar.'),
(11, 'Spaghetti Bolognese', 15, 30, 4, 520, 28, 62, 18, '- 12 oz spaghetti\n- 1 lb ground beef\n- 24 oz marinara sauce\n- 1/2 yellow onion, diced\n- 2 garlic cloves, minced', '1. Bring a large pot of salted water to boil and cook spaghetti per package directions; drain.\n2. Heat oil in a pan, sauté diced onion and minced garlic until soft.\n3. Add ground beef, breaking it up until fully browned.\n4. Pour marinara sauce into pan, reduce heat, and simmer for 15 minutes.\n5. Serve beef sauce over cooked spaghetti.'),
(12, 'Pan-Seared Salmon with Asparagus', 10, 12, 2, 410, 36, 6, 27, '- 2 salmon fillets\n- 1 bunch fresh asparagus, trimmed\n- 2 tbsp olive oil\n- 1 lemon, cut into wedges\n- Salt and pepper to taste', '1. Pat salmon dry with paper towels; season both sides with salt, pepper, and olive oil.\n2. Heat skillet over medium-high heat and sear salmon 4-5 mins per side.\n3. Remove salmon from pan and set aside on a plate.\n4. Add trimmed asparagus to same skillet with remaining oil and sauté 4-5 mins until tender.\n5. Serve salmon alongside asparagus with fresh lemon wedges.'),
(13, 'Vegetable Stir-Fry with Tofu', 15, 12, 3, 270, 15, 22, 14, '- 1 block firm tofu, drained and cubed\n- 2 cups broccoli florets\n- 1 bell pepper, sliced\n- 3 tbsp soy sauce\n- 1 tbsp cornstarch', '1. Press excess liquid from tofu block, cut into bite-sized cubes, and coat with cornstarch.\n2. Pan-fry tofu cubes in oil over medium-high heat until golden crisp on all sides; remove.\n3. Add broccoli florets and sliced bell pepper to skillet, stir-frying for 3-4 mins.\n4. Return fried tofu to skillet with veggies.\n5. Pour soy sauce over dish, toss well to combine, and heat through.'),
(14, 'Sheet Pan Lemon Herb Chicken', 15, 35, 4, 460, 34, 26, 24, '- 4 chicken thighs, bone-in skin-on\n- 1 lb baby potatoes, halved\n- 2 tbsp olive oil\n- 1 tsp dried oregano\n- 1 lemon, juiced', '1. Preheat oven to 400°F (200°C) and grease a large sheet pan.\n2. Cut baby potatoes in half and place on sheet pan alongside chicken thighs.\n3. Drizzle olive oil, squeezed lemon juice, salt, pepper, and dried oregano over top.\n4. Toss everything gently to coat and spread out into a single layer.\n5. Bake for 35 minutes until chicken hits internal temp of 165°F and potatoes are tender.'),
(15, 'Creamy Mushroom Risotto', 15, 30, 4, 390, 9, 56, 13, '- 1.5 cups Arborio rice\n- 8 oz fresh mushrooms, sliced\n- 4 cups warm vegetable or chicken broth\n- 1/2 cup dry white wine\n- 1/2 cup Parmesan cheese, grated\n- 2 tbsp butter', '1. Heat broth in a saucepan and keep warm over low heat.\n2. Sauté sliced mushrooms in butter until brown, then remove and set aside.\n3. Add Arborio rice to pan, toast 1-2 mins, then pour in white wine and stir until absorbed.\n4. Add warm broth one ladle at a time, stirring until liquid absorbs before adding more.\n5. Once rice is tender and creamy (~20 mins), fold in mushrooms and grated Parmesan.'),
(16, 'Garlic Butter Shrimp Pasta', 10, 12, 2, 490, 28, 54, 18, '- 8 oz fettuccine pasta\n- 1/2 lb shrimp, peeled and deveined\n- 3 tbsp butter\n- 3 garlic cloves, minced\n- 2 tbsp fresh parsley, chopped', '1. Boil fettuccine in salted water according to package instructions; drain.\n2. Melt butter in a large skillet over medium-low heat and add minced garlic, cooking 1 min.\n3. Add peeled shrimp to pan, season with salt and pepper, cook 2 mins per side until pink.\n4. Add cooked pasta to pan with shrimp and butter sauce.\n5. Toss gently until pasta is coated, then garnish with fresh chopped parsley.'),
(17, 'Hummus and Pita Chips', 5, 0, 2, 230, 6, 28, 11, '- 1/2 cup prepared hummus\n- 1 bag pita chips\n- 1 tbsp extra virgin olive oil\n- 1/2 tsp smoked paprika', '1. Scoop pre-made or fresh hummus into a shallow serving bowl.\n2. Smooth surface of hummus using the back of a spoon to create small wells.\n3. Drizzle olive oil into wells and dust with smoked paprika.\n4. Serve in center of a platter surrounded by crispy pita chips.'),
(18, 'Baked Apple Cinnamon Chips', 10, 120, 2, 110, 1, 28, 0, '- 2 fresh apples, thinly sliced\n- 1 tsp ground cinnamon\n- 1 tbsp granulated sugar', '1. Preheat oven to 200°F (93°C) and line two baking sheets with parchment paper.\n2. Slice apples thinly using a knife or mandoline.\n3. Mix cinnamon and sugar together in a small bowl.\n4. Arrange apple slices in a single layer on parchment paper and sprinkle cinnamon sugar.\n5. Bake for 2 hours, flipping halfway, until slices are dry and crisp.'),
(19, 'Trail Mix Energy Balls', 15, 0, 12, 130, 4, 15, 6, '- 1 cup rolled oats\n- 1/2 cup creamy peanut butter\n- 1/3 cup honey\n- 1/4 cup mini chocolate chips\n- 1/4 cup ground flaxseed', '1. Add oats, peanut butter, honey, chocolate chips, and flaxseed into a mixing bowl.\n2. Stir mixture thoroughly until completely combined and sticky.\n3. Place bowl in refrigerator for 30 minutes so mixture hardens slightly.\n4. Roll chilled mixture between hands to form 12 separate 1-inch balls.\n5. Store energy balls in an airtight container in fridge.'),
(20, 'Classic Fudgy Brownies', 15, 25, 9, 240, 3, 32, 12, '- 1/2 cup unsalted butter, melted\n- 1 cup granulated sugar\n- 2 large eggs\n- 1/3 cup unsweetened cocoa powder\n- 1/2 cup all-purpose flour', '1. Preheat oven to 350°F (175°C) and line an 8x8 baking pan with parchment paper.\n2. Whisk melted butter and sugar in a bowl, then beat in eggs one at a time.\n3. Sift cocoa powder and flour into wet mixture.\n4. Fold ingredients together using a spatula until just combined.\n5. Pour batter into pan and bake for 25 minutes until a toothpick inserted comes out with moist crumbs.'),
(21, 'Vanilla Bean Panna Cotta', 15, 5, 4, 280, 4, 18, 22, '- 1 cup heavy cream\n- 1 cup whole milk\n- 1/4 cup granulated sugar\n- 1 tsp vanilla bean paste\n- 2.25 tsp unflavored gelatin powder', '1. Sprinkle gelatin powder over 2 tbsp cold water in a small dish and let bloom for 5 mins.\n2. Heat heavy cream, milk, and sugar in a saucepan over medium heat until sugar dissolves.\n3. Remove pan from heat, add vanilla paste, and whisk in bloomed gelatin until dissolved.\n4. Pour mixture through a fine strainer into ramekins or molds.\n5. Refrigerate molds for at least 4 hours until fully set before serving.'),
(22, 'Fresh Fruit Salad with Mint', 10, 0, 4, 80, 1, 20, 0, '- 1 cup fresh strawberries, sliced\n- 1 cup fresh blueberries\n- 1 cup fresh pineapple, diced\n- 1 tbsp fresh mint, finely chopped\n- 1 tbsp fresh lime juice', '1. Wash strawberries, blueberries, and pineapple; slice strawberries and cut pineapple into chunks.\n2. Place prepared fruits into a clean mixing bowl.\n3. Finely chop fresh mint leaves and sprinkle over fruit.\n4. Pour fresh lime juice over mixture and toss gently to combine.\n5. Cover bowl and chill in refrigerator for 15 minutes before serving.');

-- Mapping the recipe data to categories
INSERT INTO `recipe_categories` (`recipe_id`, `category_id`) VALUES
(2, 1),  -- Oatmeal Pancakes -> Breakfast
(5, 2),  -- Caesar Wrap -> Lunch
(6, 2),  -- Caprese Sandwich -> Lunch
(9, 2),  -- Grilled Cheese -> Lunch
(10, 3), -- Tacos -> Dinner
(11, 3), -- Spaghetti -> Dinner
(12, 3), -- Salmon -> Dinner
(14, 3), -- Sheet Pan Chicken -> Dinner
(15, 3), -- Risotto -> Dinner
(16, 3), -- Shrimp Pasta -> Dinner
(17, 4), -- Hummus -> Snack
(18, 4), -- Apple Chips -> Snack
(19, 4), -- Energy Balls -> Snack
(20, 5), -- Brownies -> Dessert
(21, 5), -- Panna Cotta -> Dessert

-- This could fall on 2 different categories 
(1, 1), (1, 4),   -- Avocado Toast (Breakfast & Snack)
(3, 1), (3, 4),   -- Yogurt Bowl (Breakfast & Snack)
(4, 2), (4, 3),   -- Quinoa Salad (Lunch & Dinner)
(7, 2), (7, 3),   -- Chicken Fried Rice (Lunch & Dinner)
(8, 2), (8, 3),   -- Tomato Soup (Lunch & Dinner)
(13, 2), (13, 3), -- Tofu Stir Fry (Lunch & Dinner)
(22, 4), (22, 5); -- Fruit Salad (Snack & Dessert)