<?php
namespace App\Helpers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthHelper {
    public static function getUser(string $username, string $password): Dosen|Mahasiswa|null {
        try {
            \Log::info('cobamasuk');
            $user = User::where('username', $username)->first();
            if (!$user || !Hash::check($password, $user->password)) {
                return null;
            }

            if ($user->level == 1) {
                \Log::error('Ketemu Mahasiswa');
                $mahasiswa = Mahasiswa::where('nim', $user->username)->first();
                if (!$mahasiswa) {
                    \Log::info('Membuat Mahasiswa baru', ['username' => $user->username]);
                    try {
                        $mahasiswa = Mahasiswa::create([
                            'nim' => $user->username,
                            'nama' => $user->nama_lengkap,
                            'password' => $user->password,
                        ]);
                        \Log::info('Mahasiswa berhasil dibuat', ['id' => $mahasiswa->id]);
                    } catch (\Throwable $th) {
                        \Log::error('Gagal membuat mahasiswa', ['error' => $th->getMessage()]);
                    }
                } else {
                    if ($mahasiswa->password !== $user->password) {
                        $mahasiswa->password = $user->password;
                        $mahasiswa->save();
                        \Log::info('Password mahasiswa updated', ['nim' => $mahasiswa->nim]);
                    }
                }
                return $mahasiswa;
            }

            if (in_array($user->level, [7, 8, 9, 10, 11, 13])) {
                $dosen = Dosen::where('no_induk', $user->username)->first();
                if (!$dosen) {
                    \Log::error('Ganok dosen e');
                    try {
                        // Check if user is koorprodi in second_db
                        $isKaprodi = DB::connection('second_db')
                            ->table('koorprodi')
                            ->where('id_prodi', 10)
                            ->where('id_jenjang', 4)
                            ->where('koorprodi', $user->user_id)
                            ->exists();

                        $role = $isKaprodi ? 'kaprodi' : 
                               ($user->level == 13 ? 'eksternal' : 'dosen');

                        $dosen = Dosen::create([
                            'no_induk' => $user->username,
                            'nama' => $user->nama_lengkap,
                            'email' => $user->email,
                            'password' => $user->password,
                            'role' => $role,
                            'pangkat_gol' => 'belum diisi'
                        ]);
                        \Log::info('Dosen berhasil dibuat', [
                            'id' => $dosen->id,
                            'role' => $role
                        ]);
                    } catch (\Throwable $th) {
                        \Log::error('Gagal membuat dosen', ['error' => $th->getMessage()]);
                    }
                } else {
                    if ($dosen->password !== $user->password) {
                        $dosen->password = $user->password;
                        $dosen->save();
                        \Log::info('Password dosen updated', ['no_induk' => $dosen->no_induk]);
                    }
                }
                return $dosen;
            }

            return null;
        } catch (\Throwable $th) {
            \Log::error('Error in getUser', ['error' => $th->getMessage()]);
            return null;
        }
    }

    private static function mapDosenRole(int $level): string {
        return match ($level) {
            7,9,10,11 => 'dosen',
            8 => 'kaprodi',
            13 => 'eksternal',
            default => 'dosen'
        };
    }

    public static function signOut() {
        auth()->guard('dosen')->logout();
        auth()->guard('mahasiswa')->logout();
    }

    public static function user(): Dosen|Mahasiswa|null {
        return auth()->guard('dosen')->user() ?? auth()->guard('mahasiswa')->user();
    }

    public static function getRole(): string {
        if (!self::user()) {
            return 'guest';
        }
        return self::isDosen() ? 'dosen' : 'mahasiswa';
    }

    public static function isDosen(): bool {
        return auth()->guard('dosen')->check();
    }
    
    public static function isKaprodi(): bool {
        return self::isDosen() && auth()->guard('dosen')->user()->role == 'kaprodi';
    }

    public static function isDosenEks(): bool {
        return self::isDosen() && auth()->guard('dosen')->user()->role == 'eksternal';
    }
    
    public static function isMahasiswa(): bool {
        return auth()->guard('mahasiswa')->check();
    }
}