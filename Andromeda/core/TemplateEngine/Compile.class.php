<?php 
/**
* 模板编译工具类
*/
class Compile
{
	
	private $template;				//带编译文件
	private $content; 				//需要替换的文本
	private $comfile;				//编译后的文件
	private $left = '{';			//左界定符
	private $right = '}';			//右界定符
	private $value = array();		//值栈
	private $php_turn;
	private $T_P = array();
	private $T_R = array();

	public function __construct($template, $compileFile, $config)
	{
		$this->template = $template;
		$this->comfile = $compileFile;
		$this->content = file_get_contents($template);
		if($config['php_turn'] === false)
		{
			$this->T_P[] = "/<\?(=|php|)(.+?)\?>/is";
			$this->T_R[] = "&lt;? \\1\\2? &gt";
		}

		//{$var}
		$this->T_P[] = "/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/";

		//{foreach $b}或者{loop $b}
		$this->T_P[] = "/\{(loop|foreach) \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/i";
		
		//{[K|V]}
		$this->T_P[] = "/\{([K|V])\}/";

		//{/foreach}或者{\loop}或者{\if}
		$this->T_P[] = "/\{\/(loop|foreach|if)}/i";

		//{if (condition)}
		$this->T_P[] = "/\{if (.* ?)\}/i";

		//{(else if | elseif)}
		$this->T_P[] = "/\{(else if|elseif) (.* ?)\}/i";

		//{else}
		$this->T_P[] = "/\{else\}/i";
		
		//{#...# 或者 *...#，注释}
		$this->T_P[] = "/\{(\#|\*)(.* ?)(\#|\*)\}/";

		$this->T_R[] = "<?php echo \$this->value['\\1']; ?>";
		$this->T_R[] = "<?php foreach ((array)\$this->value['\\2'] as \$K => \$V) { ?>";
		$this->T_R[] = "<?php echo \$\\1; ?>";
 		$this->T_R[] = "<?php } ?>";
 		$this->T_R[] = "<?php if (\\1) { ?>";
 		$this->T_R[] = "<?php }else if (\\2) { ?>";
 		$this->T_R[] = "<?php }else{ ?>";
 		$this->T_R[] = "";
	}

	public function compile()
	{
		$this->c_all();
		$this->c_staticFile();
		file_put_contents($this->comfile, $this->content);
	}

	public function c_all()
	{
		$this->content = preg_replace($this->T_P, $this->T_R, $this->content);
	}

	/**
	 * 加入对JavaScript文件的解析
	 * @return [type] [description]
	 */
	public function c_staticFile()
	{
		$this->content = preg_replace('/\{\!(.* ?)\!\}/', '<script src=\\1'.'?t='.time().'></script>', $this->content);
	}

	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		if(isset($this->$name))
		{
			return $this->$name;
		}
		else
		{
			return null;
		}
	}
}