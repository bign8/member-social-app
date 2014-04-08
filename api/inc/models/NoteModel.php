<?php

class NoteModel extends ApiModel {
	public function insert($srcID, $destID, $note) {
		$sth = $this->db->prepare("INSERT INTO note (srcID, destID, note, \"when\") VALUES (?,?,?,CURRENT_TIMESTAMP);");
		$sth->execute(array( $srcID, $destID, $note ));
		return $this->db->lastInsertId();
	}
	public function update($noteID, $note) {
		$sth = $this->db->prepare("UPDATE note SET note=?, \"when\"=CURRENT_TIMESTAMP WHERE noteID=?;");
		return $sth->execute(array( $note, $noteID ));
	}
}