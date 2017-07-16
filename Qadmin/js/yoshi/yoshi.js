/*********************************************************************************************/
// $Yoshi v1.3 || CODEDROID12 || Exclusive to CodeCanyon
/*********************************************************************************************/	
var yoshiID;
;(function($){
var Yoshi={
		defaults:{
			// PARTICLE SETTINGS
			num_particles:100,			// NUMBER OF ANIMATED PARTICLES
			particles:[],				// ARRAY TO HOLD PARTICLES (INTERNAL)
			min_distance:50,			// DISTANCE TO DRAW LINE
			particle_size:20,			// SIZE OF PARTICLES (0=RANDOM)
			max_size:5,					// MAXIMUM PARTICLE RADIUS
			particle_color:'#000000',	// PARTICLE COLOR
			switch_color:false,			// RANDOMLY SELECT DIFFERENT COLORS DURING ANIMATION
			particle_shape:'triangle',	// PARTICLE SHAPE ('CIRCLE','LINE')
			particle_width:3,			// USED WITH PARTICLE_SHAPE LINES
			max_particle_width:3,		// MAXIMUM PARTICLE WIDTH
			particle_height:0,			// USED WITH PARTICLE_SHAPE LINES
			max_particle_height:0,		// MAXIMUM PARTICLE HEIGHT
			// GENERAL SETTINGS
			canvas_color:'transparent',	// BACKGROUND COLOR (#HEX, TRANSPARENT OR BLEND)
			speed_x:2,					// SPEED FACTOR ALONG X AXIS
			max_speed_x:1,				// MAXIMUM SPEED ALONG X AXIS			
			speed_y:2,					// SPEED FACTOR ALONG Y AXIS
			max_speed_y:1,				// MAXIMUM SPEED ALONG Y AXIS
			velocity_x:1,				// VELOCITY FACTOR ALONG X AXIS
			velocity_y:1,				// VELOCITY FACTOR ALONG Y AXIS
			x_type:1,					// CONTROLS HOW DIRECTION IS CALCULATED 0=*, 1=+, 2=-, 3=/  
			y_type:1,					// CONTROLS HOW DIRECTION IS CALCULATED 0=*, 1=+, 2=-, 3=/  
			acceleration_x:0.01,		// ACCELERATION SPEED FACTOR ALONG X AXIS (0=RANDOM)
			acceleration_y:0.01,		// ACCELERATION SPEED FACTOR ALONG X AXIS (0=RANDOM)
			// LINE SETTINGS
			draw_line:false,				// DRAWS LINES WHEN PARTICLES ARE CLOSE
			line_color:'#000000',		// LINE COLOR
			line_width:2,				// WIDTH OF LINES
			line_type:'line',		// LINE, BEZIER, QUAD OR RANDOM
			line_type_array:['line','quad','bezier'], // INTERNAL USE FOR RANDOM LINE TYPE SELECTION
			control_point_a_x:true,		// FIRST CONTROL POINT X WHEN USING BEZIER LINE TYPE (0=RANDOM, TRUE=USE POINT POSITION)
			control_point_a_y:true,		// FIRST CONTROL POINT Y WHEN USING BEZIER LINE TYPE (0=RANDOM, TRUE=USE POINT POSITION)
			control_point_b_x:true,		// SECOND CONTROL POINT X WHEN USING BEZIER LINE TYPE (0=RANDOM, TRUE=USE POINT POSITION)
			control_point_b_y:true		// SECOND CONTROL POINT Y WHEN USING BEZIER LINE TYPE (0=RANDOM, TRUE=USE POINT POSITION)		
		}, 
	
/***********************************************************************************************/
// INITIALIZE
/***********************************************************************************************/
init:function(options){
	var o=options,
		$this=$(this);
		
	/////////////
	// EACH Yoshi
	/////////////
	$this.each(function(i){
		// MERGE USER OPTIONS WITH DEFAULTS
		var $this=$(this), dist,
			settings=$.extend({}, Yoshi.defaults, o);

		///////////////////////////////////////
		// CREATE AND INITIALIZE CANVAS ELEMENT
		///////////////////////////////////////
		$this.append('<canvas class="Yoshi_particleEffects"></canvas>');
		var canvas=$this.find('canvas.Yoshi_particleEffects')[0];
		var ctx=canvas.getContext('2d');
		// SETUP DIMENSIONS
		settings.width=$this.width();
		settings.height=$this.height();
		canvas.width=settings.width; 
		canvas.height=settings.height;


		///////////////////
		// CREATE PARTICLES
		///////////////////
		function Particle(){
			var partColors=settings.particle_color.split(','),
				speed_x=settings.speed_x=='r' ? Math.random()*settings.max_speed_x : settings.speed_x,
				speed_y=settings.speed_y=='r' ? Math.random()*settings.max_speed_y : settings.speed_y;
				
			// RANDOM POSITIONING, COLORS, VELOCITIES AND OTHER PROPS
			this.color=partColors.length > 1 ? partColors[Math.floor(Math.random()*partColors.length)] : partColors[0];
			this.x=Math.random()*settings.width;
			this.y=Math.random()*settings.height;
			this.vx=-1+Math.random()*speed_x;
			this.vy=-1+Math.random()*speed_y;
			this.radius=settings.particle_size===0 ? Math.random()*settings.max_size : settings.particle_size;
			this.particleWidth=settings.particle_width===0 ? Math.random()*settings.max_particle_width : settings.particle_width;
			this.particleHeight=settings.particle_height===0 ? Math.random()*settings.max_particle_height : settings.particle_height;
			

			////////////////
			// DRAW FUNCTION
			////////////////
			this.draw=function(){

				ctx.fillStyle=settings.switch_color ? partColors[Math.floor(Math.random()*partColors.length)] : this.color;
				this.color;
				ctx.beginPath();
				// PARTICLE SHAPES
				switch(settings.particle_shape){
					case 'circle' :
						ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2, false);
						ctx.fill();
					break;
					case 'line':
						ctx.moveTo(this.x,this.y);
						ctx.lineTo(this.x+this.particleWidth,this.y+this.particleHeight);
					 	ctx.strokeStyle=settings.switch_color ? partColors[Math.floor(Math.random()*partColors.length)] : this.color;
						ctx.stroke();
					break;
					case 'triangle':
					    var	triangle=new Path2D();
					    triangle.moveTo(this.x,this.y);
					    triangle.lineTo(this.x+(this.particleWidth/2),this.y+this.particleHeight);
					    triangle.lineTo(this.x-(this.particleWidth/2),this.y+this.particleHeight);
					    triangle.closePath();
						ctx.strokeStyle=settings.switch_color ? partColors[Math.floor(Math.random()*partColors.length)] : this.color;
					    ctx.stroke(triangle);	
				};
			};
		};


		/////////////////////////
		// ADD PARTICLES TO ARRAY
		/////////////////////////
		settings.particles=[];
		for(var i=0; i<settings.num_particles; i++){ settings.particles.push(new Particle()); };
		
		
		/////////////////////
		// MAIN DRAW FUNCTION
		/////////////////////
		function draw(){
			// FIRST PAINT THE CANVAS
			Yoshi.paintCanvas(ctx, settings);
			// LOOP PARTICLES AND DRAW EACH ONE
			for(var i=0; i<settings.particles.length; i++){ 
				var p=settings.particles[i]; 
				p.draw(); 
			};
			// UPDATE PARTICLES
			update();
		};

		///////////////////////////////////
		// ADD PERSONALITY TO EACH PARTICLE
		///////////////////////////////////
		function update(){
			for(var i=0; i<settings.particles.length; i++){
				p=settings.particles[i];
				//////////////////
				// UPDATE VELOCITY
				//////////////////
				switch(settings.x_type){
					case 0: p.x+=p.vx*settings.velocity_x; break;
					case 1: p.x+=p.vx+settings.velocity_x; break;
					case 2: p.x+=p.vx-settings.velocity_x; break;
					case 3: p.x+=p.vx/settings.velocity_x; break;
				};
				
				switch(settings.y_type){
					case 0: p.y+=p.vy*settings.velocity_y; break;
					case 1: p.y+=p.vy+settings.velocity_y; break;
					case 2: p.y+=p.vy-settings.velocity_y; break;
					case 3: p.y+=p.vy/settings.velocity_y; break;
				};
				
				/////////////////////////////
				// HANDLE PARTICLE BOUNDARIES
				/////////////////////////////
				if(p.x+p.radius > settings.width){ 
					p.x=p.radius;
				}else if(p.x-p.radius < 0){ 
					p.x=settings.width-p.radius; 
				};
				
				if(p.y+p.radius > settings.height){ 
					p.y=p.radius;		
				}else if(p.y-p.radius < 0){ 
					p.y=settings.height-p.radius; 
				};

				// HANDLE ATTRACTION
				for(var j=i+1; j<settings.particles.length; j++){ 
					p2=settings.particles[j]; Yoshi.distance(p, p2, ctx, settings); 
				};
			};
		};

		///////////////////////
		// BEGIN ANIMATION LOOP
		///////////////////////
		function animloop(){ draw(); yoshiID=requestAnimFrame(animloop); };
		animloop();


		// UPDATE THE CANVAS SIZE
		$(window).on('resize.yoshi',function(){
			var $canvas=$this.find('canvas.Yoshi_particleEffects'),
				w=$canvas.width(),
				h=$canvas.height();
			$canvas[0].width=w;
			$canvas[0].height=h;				
		});
	});
},



/***********************************************************************************************/
// CALCULATE THE DISTANCE BETWEEN PARTICLES
/***********************************************************************************************/
distance:function(p1, p2, ctx, settings){
	var dist, dx=p1.x-p2.x, dy=p1.y-p2.y;
	dist=Math.sqrt(dx*dx+dy*dy);
		
	// DRAW LINES IF PARTICLES ARE CLOSE ENOUGH
	if(settings.draw_line && dist <= settings.min_distance){
		// USE RANDOM LINE COLORS (ARRAYS)		
		var numLineColors=settings.line_color.split(',');		
		if(numLineColors.length > 1){
			lineColor=Yoshi.hexToRgb(numLineColors[Math.floor(Math.random()*numLineColors.length)]);
		}else{
			lineColor=Yoshi.hexToRgb(numLineColors[0]);
		};
		
		ctx.beginPath();
		ctx.strokeStyle='rgba('+lineColor.r+','+lineColor.g+','+lineColor.b+','+ (1.2-dist/settings.min_distance) +')';
		ctx.lineWidth=settings.line_width;
		ctx.moveTo(p1.x, p1.y);

		////////////////////////////////////////////
		// DECIDE LINE TYPE AND ALLOW FOR RANDOMNESS
		////////////////////////////////////////////
		switch(settings.line_type==='random' ? settings.line_type_array[Math.floor(Math.random()*3)] : settings.line_type){
			case 'line':
				ctx.lineTo(p2.x, p2.y);			
			break;
			case 'bezier':
				var ctrl_pt_a_x=settings.control_point_a_x===true ? p1.x : settings.control_point_a_x===0 ? Math.random()*100 : settings.control_point_a_x,
					ctrl_pt_a_y=settings.control_point_a_y===true ? p1.y : settings.control_point_a_y===0 ? Math.random()*100 : settings.control_point_a_y,
					ctrl_pt_b_x=settings.control_point_b_x===true ? p2.x : settings.control_point_b_x===0 ? Math.random()*100 : settings.control_point_b_x,
					ctrl_pt_b_y=settings.control_point_b_y===true ? p2.y : settings.control_point_b_y===0 ? Math.random()*100 : settings.control_point_b_y;
				ctx.bezierCurveTo(ctrl_pt_a_x, ctrl_pt_a_y, ctrl_pt_b_x, ctrl_pt_b_y, p2.x, p2.y);
			break;
			case 'quad':
				var ctrl_pt_a_x=settings.control_point_a_x===true ? p1.x : settings.control_point_a_x===0 ? Math.random()*100 : settings.control_point_a_x,
					ctrl_pt_a_y=settings.control_point_a_y===true ? p1.y : settings.control_point_a_y===0 ? Math.random()*100 : settings.control_point_a_y,
					ctrl_pt_b_x=settings.control_point_b_x===true ? p2.x : settings.control_point_b_x===0 ? Math.random()*100 : settings.control_point_b_x,
					ctrl_pt_b_y=settings.control_point_b_y===true ? p2.y : settings.control_point_b_y===0 ? Math.random()*100 : settings.control_point_b_y;
				 ctx.quadraticCurveTo(ctrl_pt_a_x, ctrl_pt_a_y, ctrl_pt_b_x, ctrl_pt_b_y, p2.x, p2.y);
			break;
		};
		
		ctx.stroke();
		ctx.closePath();
		ctx.lineCap="round";		
		// PARTICLE ACCELERATION
		var ax=dx/2000,
			ay=dy/2000,
			accX=settings.acceleration_x===0 ? Math.random() : settings.acceleration_x,
			accY=settings.acceleration_y===0 ? Math.random() : settings.acceleration_y;
		p1.vx-=ax*accX;
		p1.vy-=ay*accY;
		p2.vx+=ax*accX;
		p2.vy+=ay*accY;
	};
},


/***********************************************************************************************/
// CONVERT HEX COLORS TO RGB
/***********************************************************************************************/
hexToRgb:function(hex){
    var result=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
},

/***********************************************************************************************/
// PAINT CANVAS BACKGROUND
/***********************************************************************************************/
paintCanvas:function(ctx, settings){
	// CLEAR CANVAS FOR TRANSPARENT COLOR
	if(settings.canvas_color==='transparent'){
		ctx.clearRect(0,0,settings.width,settings.height);		
	// USING RGBA WITH 0 ALPHA RESULTS IN COOL BLEND EFFECT
	}else if(settings.canvas_color==='blend'){
		ctx.fillStyle='rgba(0,0,0,0)';
		ctx.fillRect(0, 0, settings.width, settings.height);
	// FILL WITH CANVAS COLOR
	}else{ 
		ctx.fillStyle=settings.canvas_color;
		ctx.fillRect(0, 0, settings.width, settings.height);
	};
}};

/***********************************************************************************************/
// PLUGIN DEFINITION
/***********************************************************************************************/
$.fn.Yoshi=function(method,options){
	if(Yoshi[method]){ return Yoshi[method].apply(this,Array.prototype.slice.call(arguments,1));
	}else if(typeof method==='object'||!method){ return Yoshi.init.apply(this,arguments);
	}else{ $.error('Method '+method+' does not exist'); }
}})(jQuery);

// REQUESTANIMATIONFRAME
window.requestAnimFrame=(function(){ return window.requestAnimationFrame ||  window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback){ window.setTimeout(callback, 1000 / 60); }; })();